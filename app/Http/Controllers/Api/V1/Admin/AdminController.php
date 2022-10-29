<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminStoreRequest;
use App\Http\Resources\UserResource;
use App\Models\Laundry;
use App\Models\User;
use App\Models\Parfume;
use Validator;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    
    public function index()
    {
    
    if(auth()->user()->tokenCan('adminDo')){
        $admin = User::where('role',1)
        ->get();

        return UserResource::collection($admin);
        }
    return response()->json("Permintaan ditolak");
    }

    // public function detail(User $admin)
    // {
    //     return view('pages.admin.detail', compact('admin'));
    // }


    public function store(Request $AdminStoreRequest)
    {
        if(auth()->user()->tokenCan('adminDo')){
            $validator = Validator::make($AdminStoreRequest->all(),[
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|min:8',
                'no_hp' => 'required|min:11'
            ]);

            if($validator->fails()){
                return response()->json([
                    'error' => 'Format Inputan Tidak Sesuai',
                    'message' => $validator->errors()
                ]);
            }

            $user = User::create([
                'name' => $AdminStoreRequest->name,
                'email' => $AdminStoreRequest->email,
                'password' => bcrypt($AdminStoreRequest->password),
                'no_hp' => $AdminStoreRequest->no_hp,
                'role' => User::ROLE_ADMIN
            ]);

            return UserResource::make($user);
        }
        return response()->json("Permintaan ditolak");
    }

    public function destroy(User $admin)
    {
        if(auth()->user()->tokenCan('adminDo')){
            User::find($admin->id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil Menghapus Admin!'
            ]);
        }
        return response()->json("Permintaan Ditolak");
    }


}
