<?php

namespace App\Http\Controllers\Api\V1\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\CatalogStoreRequest;
use App\Http\Resources\CatalogResource;
use App\Models\Catalog;
use App\Models\Laundry;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\ValidationException;

class CatalogController extends Controller
{
    public function index(Laundry $laundry)
    {
        // throw_if(
        //     !auth()->user()->tokenCan('catalog.show')
        //         || auth()->id() != $laundry->user_id,
        //     ValidationException::withMessages(['catalog' => 'Tidak dapat melihat layanan!'])
        // );
        if(auth()->user()->tokenCan('ownerDo')){
            $catalogs = Catalog::query()
            ->whereBelongsTo($laundry)
            ->get();

            return CatalogResource::collection($catalogs);
        }

        return response()->json("Permintaan ditolak");

        
    }

    public function store(Request $catalogStoreRequest, Laundry $laundry)
    {
        // throw_if(
        //     auth()->id() != $laundry->user_id,
        //     ValidationException::withMessages(['catalog' => 'Tidak dapat membuat layanan!'])
        // );

        if(auth()->user()->tokenCan('ownerDo')){
            $validator = Validator::make($catalogStoreRequest->all(),[
                'name' => 'required',
                'icon' => 'required',
                'unit' => 'required',
                'price' => 'required|integer',
                'estimation_complete' => 'required|integer',
                'estimation_type' => 'required'
            ]);

            if($validator->fails()){
                return response()->json([
                    'error' => 'Format Inputan Tidak Sesuai',
                    'message' => $validator->errors()
                ]);
            }


            $catalog = $laundry->catalogs()->create( 
                [
                    'name' => $catalogStoreRequest->name,
                    'icon' => $catalogStoreRequest->icon,
                    'unit' => $catalogStoreRequest->unit,
                    'price' => $catalogStoreRequest->price,
                    'estimation_complete' => $catalogStoreRequest->estimation_complete,
                    'estimation_type' => $catalogStoreRequest->estimation_type,
                ]
            );

            // $catalog = $laundry->catalogs()
            //     ->create($catalogStoreRequest->validated());

            return CatalogResource::make($catalog);
        }

        return response()->json("Permintaan ditolak");
    }

    public function update(Request $catalogStoreRequest, Laundry $laundry, Catalog $catalog)
    {
        // throw_if(
        //     auth()->id() != $laundry->user_id,
        //     ValidationException::withMessages(['catalog' => 'Tidak dapat mengubah layanan!'])
        // );

        if(auth()->user()->tokenCan('ownerDo') && auth()->id() == $laundry->user_id && $laundry->id == $catalog->laundry_id){
            $validator = Validator::make($catalogStoreRequest->all(),[
                'name' => 'required',
                'icon' => 'required',
                'unit' => 'required',
                'price' => 'required|integer',
                'estimation_complete' => 'required|integer',
                'estimation_type' => 'required'
            ]);

            if($validator->fails()){
                return response()->json($validator->errors());
            }


            // $catalog->update( 
            //     [
            //         'name' => $catalogStoreRequest->name,
            //         'icon' => $catalogStoreRequest->icon,
            //         'unit' => $catalogStoreRequest->unit,
            //         'price' => $catalogStoreRequest->price,
            //         'estimation_complete' => $catalogStoreRequest->estimation_complete,
            //         'estimation_type' => $catalogStoreRequest->estimation_type,
            //     ]
            // );

            $catalog->update($catalogStoreRequest->all());

            return CatalogResource::make($catalog);

        }

        return response()->json("Permintaan ditolak");
    }

    public function destroy(Laundry $laundry, Catalog $catalog)
    {
        // throw_if(
        //     !auth()->user()->tokenCan('catalog.destroy')
        //         || auth()->id() != $laundry->user_id
        //         || $laundry->id != $catalog->laundry_id,
        //     ValidationException::withMessages(['catalog' => 'Tidak dapat menghapus layanan!'])
        // );
        if(auth()->user()->tokenCan('ownerDo') && auth()->id() == $laundry->user_id && $laundry->id == $catalog->laundry_id){

            $catalog->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Berhasil Menghapus Layanan!'
            ]);
        }

        return response()->json("Permintaan ditolak");
    }
}
