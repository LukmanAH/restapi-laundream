<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\InformationResourceAdmin;
use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InformationController extends Controller
{
    public function index()
    {
        if (auth()->user()->tokenCan('adminDo')) {
            $info = Information::with('user')
                ->get();

            return InformationResourceAdmin::collection($info);
        }
        return response()->json("Permintaan ditolak");
    }

    public function store(Request $informationStoreRequest)
    {
        if (auth()->user()->tokenCan('adminDo')) {
            $validator = Validator::make($informationStoreRequest->all(), [
                'title' => 'required|string|max:255',
                'description' => 'required|string|',
                'picture' => 'mimes:jpeg,jpg,png|max:5000|nullable',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors());
            }


            $info = Information::create([
                'title' => $informationStoreRequest->title,
                'description' => $informationStoreRequest->description,
                'user_id' =>  auth()->id(),
                'status' => Information::STATUS_ACTIVE
            ]);

            if ($informationStoreRequest->hasFile('picture')) {
                $file = $informationStoreRequest->file('picture')->getClientOriginalName();
                
                $path = $informationStoreRequest->file('picture')->storeAs(
                    'laundream/info',
                    now()->timestamp . $file,
                    's3'
                );
;

                $info->update([
                    'picture' => $path
                ]);
            }

            return InformationResourceAdmin::make($info);
        }
        return response()->json("Permintaan ditolak");
    }


    public function status(Request $request, Information $information)
    {
        if (auth()->user()->tokenCan('adminDo')) {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'required|string|',
                'status' => 'required|integer',
                'picture' => 'nullable|sometimes|mimes:jpeg,jpg,png|max:5000',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors());
            }

            $information->update(['status' => $request->status, 'title' => $request->title, 'description' => $request->description]);


            return response()->json($information);;
        }
        return response()->json("Permintaan ditolak");
    }

    public function destroy(Information $information)
    {
        if (auth()->user()->tokenCan('adminDo')) {
            Information::find($information->id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil Menghapus Informasi!'
            ]);
        }
        return response()->json("Permintaan ditolak");
    }
}
