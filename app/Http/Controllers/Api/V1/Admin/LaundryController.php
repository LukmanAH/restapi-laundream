<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LaundryStoreRequest;
use App\Http\Resources\LaundryResourceAdmin;
use App\Models\Laundry;
use App\Models\User;
use Validator;
use App\Models\Transactions;
use Illuminate\Http\Request;

class LaundryController extends Controller
{
    public function index()
    {
        if(auth()->user()->tokenCan('adminDo')){
            $laundries = Laundry::with('user')
                ->withCount('employees')
                ->withCount('transactions')
                ->get();

            return LaundryResourceAdmin::collection($laundries);
        }
        return response()->json("Permintaan ditolak");
    }

    // public function detail(Laundry $laundry)
    // {
    //     return view('pages.laundry.detail', compact('laundry'));
    // }

    public function store(Request $laundryStoreRequest)
    {

        if(auth()->user()->tokenCan('adminDo')){
            $validator = Validator::make($laundryStoreRequest->all(),[
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|min:8',
                'no_hp' => 'required|min:11|max:20',
                'owner_name' => 'required|string|max:255',
            ]);

            if($validator->fails()){
                return response()->json($validator->errors());
            }

            $user = User::create([
                'name' => $laundryStoreRequest->owner_name,
                'email' => $laundryStoreRequest->email,
                'password' => bcrypt($laundryStoreRequest->password),
                'no_hp' => $laundryStoreRequest->no_hp,
                'role' => User::ROLE_OWNER
            ]);

            $user->laundry()->create([
                'name' => $laundryStoreRequest->name,
                'status' => Laundry::STATUS_ACTIVE,
                'condition' => Laundry::STATUS_CLOSE
            ]);

            return LaundryResourceAdmin::make($user);
        }
        return response()->json("Permintaan ditolak");
    }

    
    public function status(Request $request, Laundry $mitra)
    {
        $validator = Validator::make($request->all(),[
            'status' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => 'Format Inputan Tidak Sesuai',
                'message' => $validator->errors()
            ]);
        }
        
        $mitra->update(['status' => $request->status]);

        return response()->json($mitra);
    }

    public function destroy(Laundry $mitra)
    {
        if(auth()->user()->tokenCan('adminDo')){
            
            Laundry::find($mitra->id)->delete();
            User::find($mitra->user_id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil Menghapus Mitra!'
            ]);
        }
        return response()->json("Permintaan ditolak");
    }

}
