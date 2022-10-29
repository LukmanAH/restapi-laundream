<?php

namespace App\Http\Controllers\Api\V1\Owner;

use App\Http\Controllers\Controller;
use App\Http\Resources\ParfumeResource;
use App\Models\Laundry;
use App\Models\Parfume;
use Illuminate\Validation\ValidationException;
use Validator;

class ParfumeController extends Controller
{
    public function index(Laundry $laundry)
    {
        // throw_if(
        //     !auth()->user()->tokenCan('parfume.show')
        //         || auth()->id() != $laundry->user_id,
        //     ValidationException::withMessages(['parfume' => 'Tidak dapat melihat parfum!'])
        // );

        if(auth()->user()->tokenCan('ownerDo')
              && auth()->id() == $laundry->user_id){

            $parfumes = Parfume::query()
                ->whereBelongsTo($laundry)
                ->get();

            return ParfumeResource::collection($parfumes);
        }
        return response()->json("Permintaan ditolak");
        }

    public function store(Laundry $laundry)
    {
        // throw_if(
        //     !auth()->user()->tokenCan('parfume.create')
        //         || auth()->id() != $laundry->user_id
        //         || is_null(request('name')),
        //     ValidationException::withMessages(['parfume' => 'Tidak dapat membuat parfum!'])
        // );

        if( auth()->user()->tokenCan('ownerDo')
                 && auth()->id() == $laundry->user_id){

            
            $validator = Validator::make(Request()->all(),[
                'name' => 'required|string|max:255',    
            ]);
        
            if($validator->fails()){
                return response()->json([
                    'error' => 'Format Inputan Tidak Sesuai',
                    'message' => $validator->errors()                    ]);
            }

            $parfume = $laundry->parfumes()->create(
                ['name' => request('name')]
            );

            return ParfumeResource::make($parfume);
        }
        return response()->json("Permintaan ditolak");
    }

    public function update(Laundry $laundry, Parfume $parfume)
    {
        // throw_if(
        //     !auth()->user()->tokenCan('parfume.update')
        //         || auth()->id() != $laundry->user_id
        //         || $parfume->laundry_id != $laundry->id
        //         || is_null(request('name')),
        //     ValidationException::withMessages(['parfume' => 'Tidak dapat mengubah parfum!'])
        // );

        if(auth()->user()->tokenCan('ownerDo') && auth()->id() == $laundry->user_id && $parfume->laundry_id == $laundry->id){
            $validator = Validator::make(Request()->all(),[
                'name' => 'required|string|max:255',    
            ]);
        
            if($validator->fails()){
                return response()->json([
                    'error' => 'Format Inputan Tidak Sesuai',
                    'message' => $validator->errors()                    ]);
            }
            
            $parfume->update(['name' => request('name')]);

            return ParfumeResource::make($parfume);
        }
        return response()->json('parfume => Permintaan ditolak');
    }

    public function destroy(Laundry $laundry, Parfume $parfume)
    {
        // throw_if(
        //     !auth()->user()->tokenCan('parfume.delete')
        //         || auth()->id() != $laundry->user_id
        //         || $parfume->laundry_id != $laundry->id,
        //     ValidationException::withMessages(['parfume' => 'Tidak dapat menghapus parfum!'])
        // );

        if(auth()->user()->tokenCan('ownerDo')
                && auth()->id() == $laundry->user_id
                && $parfume->laundry_id == $laundry->id){

            $parfume->delete();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil Menghapus Parfume!'
            ]);
        }
        return response()->json("Permintaan ditolak");
    }
}
