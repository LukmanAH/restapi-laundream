<?php

namespace App\Http\Controllers\Api\V1\Owner;

use App\Http\Controllers\Controller;
use App\Models\Laundry;
use App\Models\OperationalHour;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\ValidationException;

class OperationalHourController extends Controller
{
    public function index(Laundry $laundry)
    {
        // throw_if(
        //     auth()->id() != $laundry->user_id || !auth()->user()->tokenCan('ophour.list'),
        //     ValidationException::withMessages(['op_hour' => 'Tidak dapat melihat jam operasional!'])
        // );

        if(auth()->id() == $laundry->user_id && auth()->user()->tokenCan('ownerDo')){
            $operationalHour = OperationalHour::query()
                 ->whereBelongsTo($laundry)->get();

            return response()->json([
                'senin' => $operationalHour[0],
                'selasa' => $operationalHour[1],
                'rabu' => $operationalHour[2],
                'kamis' => $operationalHour[3],
                'jumat' => $operationalHour[4],
                'sabtu' => $operationalHour[5],
                'minggu' => $operationalHour[6],
                'condition' => $laundry->condition,
            ]);
        }
        return response()->json("Permintaan ditolak");
    }

    public function update(Laundry $laundry, OperationalHour $operationalHour)
    {
        // throw_if(
        //     auth()->id() != $laundry->user_id
        //         || $laundry->id != $employee->laundry_id,
        //     ValidationException::withMessages(['employee' => 'Tidak dapat mengubah karyawan!'])
        // );

        if(auth()->user()->tokenCan('ownerDo') && auth()->id() == $laundry->user_id && $laundry->id == $operationalHour->laundry_id){
            $validator = Validator::make(request()->all(),[
                'open' => 'required',
                'close' => 'required',
            ]);

            if($validator->fails()){
                return response()->json([
                    'error' => 'Format Inputan Tidak Sesuai',
                    'message' => $validator->errors()
                ]);
            }

            $operationalHour->update(request()->all());
          

            return $operationalHour;
        }
        return response()->json("Permintaan ditolak");
    }

    public function updateAll(Laundry $laundry)
    {
        // throw_if(
        //     auth()->id() != $laundry->user_id
        //         || $laundry->id != $employee->laundry_id,
        //     ValidationException::withMessages(['employee' => 'Tidak dapat mengubah karyawan!'])
        // );

        if(auth()->user()->tokenCan('ownerDo') && auth()->id() == $laundry->user_id){
            $validator = Validator::make(request()->all(),[
                'senin_open' => 'required',
                'senin_close' => 'required',
                'selasa_open' => 'required',
                'selasa_close' => 'required',
                'rabu_open' => 'required',
                'rabu_close' => 'required',
                'kamis_open' => 'required',
                'kamis_close' => 'required',
                'jumat_open' => 'required',
                'jumat_close' => 'required',
                'sabtu_open' => 'required',
                'sabtu_close' => 'required',
                'minggu_open' => 'required',
                'minggu_close' => 'required',
            ]);

            if($validator->fails()){
                return response()->json([
                    'error' => 'Format Inputan Tidak Sesuai',
                    'message' => $validator->errors()
                ]);
            }

            $operationalHour = OperationalHour::query()
            ->whereBelongsTo($laundry)->get();

            $operationalHour[0]->update(['open' => request('senin_open'), 'close'=>request('senin_close') ]);
            $operationalHour[1]->update(['open' => request('selasa_open'), 'close'=>request('selasa_close') ]);
            $operationalHour[2]->update(['open' => request('rabu_open'), 'close'=>request('rabu_close') ]);
            $operationalHour[3]->update(['open' => request('kamis_open'), 'close'=>request('kamis_close') ]);
            $operationalHour[4]->update(['open' => request('jumat_open'), 'close'=>request('jumat_close') ]);
            $operationalHour[5]->update(['open' => request('sabtu_open'), 'close'=>request('sabtu_close') ]);
            $operationalHour[6]->update(['open' => request('minggu_open'), 'close'=>request('minggu_close') ]);
            
            if(request('condition') != null){
                $laundry->update(['condition' => request('condition')]);
            }

            return $operationalHour;
        }
        return response()->json("Permintaan ditolak");
    }
}
