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

class RegisterController extends Controller
{

    public function register(Request $registerRequest)
    {
            $validator = Validator::make($registerRequest->all(),[
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|min:8',
                'no_hp' => 'required|min:11|max:14'
            ]);

            if($validator->fails()){
                return response()->json([
                    'error' => 'Format Inputan Tidak Sesuai',
                    'message' => $validator->errors()
                ]);
            }

            $user = User::create(
                [
                    'name' => $registerRequest->name,
                    'email' => $registerRequest->email,
                    'password' => bcrypt($registerRequest->password),
                    'no_hp' => $registerRequest->no_hp,
                    'role' => User::ROLE_CUSTOMER
                ]
            );
    
            return UserResource::make($user);
    }
}
