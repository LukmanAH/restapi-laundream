<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\InformationResource;
use App\Models\Information;
use App\Models\Informations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InformationController extends Controller
{
    public function index()
    {
        $info = Information::query()
            ->where('status', Information::STATUS_ACTIVE)
            ->get();
        return InformationResource::collection($info);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $info = Information::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => Information::STATUS_ACTIVE,
            'user_id' => auth()->id()
        ]);

        return InformationResource::make($info);
    }

    public function update(Request $request, Information $information)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $information->update([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->id()
        ]);

        return InformationResource::make($information);
    }

    public function destroy(Information $information)
    {
        $information->delete();

        return response()->json("Berhasil Menghapus Parfume");
    }

    public function status(Request $request, Information $information)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $information->update(['status' => $request->status]);

        return InformationResource::make($information);
    }
}
