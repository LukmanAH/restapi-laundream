<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\LaundryStoreRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Laundry;
use App\Models\ShippingRate;
use App\Models\Transaction;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Validator;

class LaundryController extends Controller
{
    public function index()
    {
        if(auth()->user()->tokenCan('customerDo')){
            $transactions = Transaction::query()
                ->with(['laundry', 'catalog', 'parfume', 'user'])
                ->where('user_id', auth()->id())
                ->get();

            return TransactionResource::collection($transactions);
        }

        return response()->json("Permintaan ditolak");
    }

    public function store(Request $laundryStoreRequest, Laundry $laundry)
    {
        if(auth()->user()->tokenCan('customerDo')){
            $validator = Validator::make($laundryStoreRequest->all(), [
                'catalog_id' => 'required|integer',
                'parfume_id' => 'required|integer',
                'service_type' => 'required|integer',
                'payment_type' => 'required|integer',
                'address'   => 'required',
                'lat'       => ['required', 'regex:/^(\+|-)?(?:90(?:(?:\.0{1,7})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,7})?))$/'],
                'lng'       => ['required', 'regex:/^(\+|-)?(?:180(?:(?:\.0{1,7})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,7})?))$/'],
                'status' => 'required|integer',
                'additional_information_user' => 'nullable',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Format Inputan Tidak Sesuai',
                    'message' => $validator->errors()
                ]);
            }


            $transaction = Transaction::query()
                ->whereBelongsTo($laundry)
                ->whereDate('created_at', today()->setTimezone('Asia/Jakarta')->toDateTimeString())
                ->get();

            $now = now()->setTimezone('Asia/Jakarta');

            $distance = (rad2deg(acos((sin(deg2rad($laundryStoreRequest->lat)) * sin(deg2rad($laundry->lat))) + (cos(deg2rad($laundryStoreRequest->lat)) * cos(deg2rad($laundry->lat)) * cos(deg2rad($laundryStoreRequest->lng - $laundry->lng))))))* 60 * 1.1515 * 1.609344;

            $transaction = Transaction::create(
                [
                    'laundry_id' => $laundry->id,
                    'user_id' => auth()->id(),
                    'serial' => "TRX/" . $now->year . $now->month . $now->day . "/" . str_pad($transaction->count(), 3, 0, STR_PAD_LEFT),
                    'catalog_id' => $laundryStoreRequest->catalog_id,
                    'parfume_id' => $laundryStoreRequest->parfume_id,
                    'service_type' => $laundryStoreRequest->service_type,
                    'payment_type' => $laundryStoreRequest->payment_type,
                    'address'   => $laundryStoreRequest->address,
                    'distance'  => $distance,
                    'lat'       => $laundryStoreRequest->lat,
                    'lng'       => $laundryStoreRequest->lng,
                    'status' => $laundryStoreRequest->status,
                    'additional_information_user' => $laundryStoreRequest->additional_information_user,
                    ]
            );
                

            if ($laundryStoreRequest->service_type == '2') {

                $shippingRate = ShippingRate::query()
                    ->whereBelongsTo($laundry)
                    ->where('initial_km', '<=', $distance)
                    ->where('final_km', '>=', $distance)
                    ->first();

                if ($shippingRate) {
                    $transaction->update([
                        'delivery_fee' => $shippingRate->price
                    ]);
                }
            }else{
                $transaction->update([
                    'delivery_fee' => 0,
                    'distance' => 0,
                ]);
            }
            return TransactionResource::make($transaction);
        }

        return response()->json("Permintaan ditolak");
    }
}
