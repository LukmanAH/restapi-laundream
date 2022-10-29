<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Laundry;
use App\Models\User;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use Exception;
use Auth;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth','verified']);
    // }

    

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => 'Format Inputan Tidak Sesuai',
                'message' => $validator->errors()
            ]);
        }

    
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'error' => 'Email & Password Salah'
            ]);
        }

        $user = User::where('email', $request->email)->firstOrFail();
            
        $laundry = Laundry::query()
            ->whereBelongsTo($user)
            ->first();
        
       
        if($user->role == 1){
            $token = $user->createToken('laundream',['adminDo'])->plainTextToken;
        }else if($user->role == 2){
            $token = $user->createToken('laundream',['ownerDo'])->plainTextToken;
        }else if($user->role == 3){
            $token = $user->createToken('laundream',['employeeDo'])->plainTextToken;
        }else if($user->role == 4){
            $token = $user->createToken('laundream',['customerDo'])->plainTextToken;
        }
        
    
        return response()->json([
            'user' => $user,
            'token' => $token,
            'error' => null,
            'laundry' => $user->role != User::ROLE_CUSTOMER ? $laundry : null
        ]);
       
    }


    public function update(Request $updateProfileRequest)
    {
            $validator = Validator::make($updateProfileRequest->all(),[
                'name' => 'required|string|max:255',
                'no_hp' => 'required|min:11|max:15',
                'password' => 'string|min:8|nullable',
                'new_password' => 'string|min:8|nullable',
            ]);

            if($validator->fails()){
                return response()->json([
                    'error' => 'Format Inputan Tidak Sesuai',
                    'message' => $validator->errors()
                ]);
            }

            $user =  auth()->user();

            if(password_verify($updateProfileRequest->password, $user->getAuthPassword())){
                $user->update(
                    [
                        'name' => $updateProfileRequest->name,
                        'password' => bcrypt($updateProfileRequest->new_password),
                        'no_hp' => $updateProfileRequest->no_hp,
                    ]
                );
                
                $pengguna = UserResource::make($user);
                return response()->json(['user' => $pengguna]);
            }else if($updateProfileRequest->password == null){
                $user->update(
                    [
                        'name' => $updateProfileRequest->name,
                        'no_hp' => $updateProfileRequest->no_hp,
                    ]
                );
                
                $pengguna = UserResource::make($user);
                return response()->json(['user' => $pengguna]);
            } 
            return response()->json(['error' => 'Password salah']);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Logout!'
        ]);
    }
}
