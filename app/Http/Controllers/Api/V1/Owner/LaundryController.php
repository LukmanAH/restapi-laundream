<?php

namespace App\Http\Controllers\Api\V1\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\LaundryUpdateRequest;
use App\Http\Resources\LaundryResource;
use App\Models\Laundry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LaundryController extends Controller
{
    public function update(Request $laundryUpdateRequest, Laundry $laundry)
    {
        // throw_if(
        //     auth()->id() != $laundry->user_id,
        //     ValidationException::withMessages(['laundry' => 'Tidak dapat mengubah laundry!'])
        // );
        if (auth()->id() == $laundry->user_id && auth()->user()->tokenCan('ownerDo')) {

            $validator = Validator::make($laundryUpdateRequest->all(), [

                'name'      => 'required',
                'banner'    => 'mimes:jpeg,jpg,png|max:5000|nullable',
                'lat'       => ['required', 'regex:/^(\+|-)?(?:90(?:(?:\.0{1,7})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,7})?))$/'],
                'lng'       => ['required', 'regex:/^(\+|-)?(?:180(?:(?:\.0{1,7})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,7})?))$/'],
                'address'   => 'required',
                'province'  => 'required',
                'city'      => 'required',
                'phone'     => 'required|min:11',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Format Inputan Tidak Sesuai',
                    'message' => $validator->errors()
                ]);
            }

            $laundry->update([
                'name'      => $laundryUpdateRequest->name,
                'lat'       => $laundryUpdateRequest->lat,
                'lng'       => $laundryUpdateRequest->lng,
                'address'   => $laundryUpdateRequest->address,
                'province'  => $laundryUpdateRequest->province,
                'city'      => $laundryUpdateRequest->city,
                'phone'     => $laundryUpdateRequest->phone,
            ]);

            if ($laundryUpdateRequest->hasFile('banner')) {
                $file = $laundryUpdateRequest->file('banner')->getClientOriginalName();

                $path = $laundryUpdateRequest->file('banner')
                    ->storeAs(
                        'laundream/banner',
                        now()->timestamp . $file,
                        's3'
                    );

                $laundry->update([
                    'banner' => config('filesystems.path') . $path
                ]);
            }


            // return $laundry;

            return LaundryResource::make($laundry);
        }
        return response()->json("Permintaan ditolak");
    }

    public function updateCondition(Request $laundryUpdateRequest, Laundry $laundry)
    {
        // throw_if(
        //     auth()->id() != $laundry->user_id,
        //     ValidationException::withMessages(['laundry' => 'Tidak dapat mengubah laundry!'])
        // );
        if (auth()->id() == $laundry->user_id && auth()->user()->tokenCan('ownerDo')) {

            $validator = Validator::make($laundryUpdateRequest->all(), [
                'condition'     => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Format Inputan Tidak Sesuai',
                    'message' => $validator->errors()
                ]);
            }

            $laundry->update([
                'condition'      => $laundryUpdateRequest->condition,
            ]);


            // return $laundry;

            return LaundryResource::make($laundry);
        }
        return response()->json("Permintaan ditolak");
    }
}
