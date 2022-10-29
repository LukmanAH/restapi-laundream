<?php

namespace App\Http\Controllers\Api\V1\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\ShippingRateStoreRequest;
use App\Http\Resources\ShippingRateResource;
use App\Models\Laundry;
use App\Models\ShippingRate;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\ValidationException;

class ShippingRateController extends Controller
{
    public function index(Laundry $laundry)
    {
        // throw_if(
        //     !auth()->user()->tokenCan('shipping.show')
        //         || auth()->id() != $laundry->user_id,
        //     ValidationException::withMessages(['shipping_rate' => 'Tidak dapat melihat tarif ongkir!'])
        // );

        if(auth()->user()->tokenCan('ownerDo') && auth()->id() == $laundry->user_id){
            $shippingRates = ShippingRate::query()
                ->whereBelongsTo($laundry)
                ->get();

            return ShippingRateResource::collection($shippingRates);
        }
        return response()->json("Permintaan ditolak");
    }

    public function store(Request $shippingRateStoreRequest, Laundry $laundry)
    {
        // throw_if(
        //     !auth()->user()->tokenCan('shipping.create')
        //         || auth()->id() != $laundry->user_id,
        //     ValidationException::withMessages(['shipping_rate' => 'Tidak dapat membuat tarif ongkir!'])
        // );

        if(auth()->user()->tokenCan('ownerDo')&& auth()->id() == $laundry->user_id){
            $validator = Validator::make($shippingRateStoreRequest->all(),[
                'initial_km' => 'required|integer',
                'final_km' => 'required|integer',
                'price' => 'required|integer',
            ]);

            if($validator->fails()){
                return response()->json([
                    'error' => 'Format Inputan Tidak Sesuai',
                    'message' => $validator->errors()
                ]);
            }


            $shippingRate = $laundry->shippingRates()->create( 
                [
                    'initial_km' => $shippingRateStoreRequest->initial_km,
                    'final_km' =>  $shippingRateStoreRequest->final_km,
                    'price' =>  $shippingRateStoreRequest->price,
                ]
            );



            return ShippingRateResource::make($shippingRate);
        }
        return response()->json("Permintaan ditolak");
    }

    public function update(Laundry $laundry, ShippingRate $shippingRate)
    {
        // throw_if(
        //     auth()->id() != $laundry->user_id
        //         || $laundry->id != $employee->laundry_id,
        //     ValidationException::withMessages(['employee' => 'Tidak dapat mengubah karyawan!'])
        // );

        if(auth()->user()->tokenCan('ownerDo') && auth()->id() == $laundry->user_id && $laundry->id == $shippingRate->laundry_id){
            $validator = Validator::make(request()->all(),[
                'initial_km' => 'required|integer',
                'final_km' => 'required|integer',
                'price' => 'required|integer',
            ]);

            if($validator->fails()){
                return response()->json([
                    'error' => 'Format Inputan Tidak Sesuai',
                    'message' => $validator->errors()
                ]);
            }

            $shippingRate->update(request()->all());
          

            return ShippingRateResource::make($shippingRate);
        }
        return response()->json("Permintaan ditolak");
    }


    public function destroy(Laundry $laundry, ShippingRate $shippingRate)
    {
        // throw_if(
        //     !auth()->user()->tokenCan('shipping.delete')
        //         || auth()->id() != $laundry->user_id
        //         || $shippingRate->laundry_id != $laundry->id,
        //     ValidationException::withMessages(['shipping_rate' => 'Tidak dapat menghapus tarif ongkir!'])
        // );

        if(auth()->user()->tokenCan('ownerDo')
        && auth()->id() == $laundry->user_id
        && $shippingRate->laundry_id == $laundry->id){
            $shippingRate->delete();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil Menghapus Ongkir!'
            ]);
        }
        return response()->json("Permintaan ditolak");
        
    }
}
