<?php

namespace App\Http\Controllers\Api\V1\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\EmployeeStoreRequest;
use App\Http\Requests\Owner\EmployeeUpdateRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\UserResource;
use App\Models\Employee;
use App\Models\Laundry;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\ValidationException;

class EmployeeController extends Controller
{
    public function index(Laundry $laundry)
    {
        // throw_if(
        //     auth()->id() != $laundry->user_id || !auth()->user()->tokenCan('employee.list'),
        //     ValidationException::withMessages(['employee' => 'Tidak dapat melihat karyawan!'])
        // );

        if(auth()->id() == $laundry->user_id && auth()->user()->tokenCan('ownerDo')){

            $employee = Employee::query()
                ->whereBelongsTo($laundry)
                ->with('user')
                ->get();

            return EmployeeResource::collection($employee);
        }
        return response()->json("Permintaan ditolak");
    }

    public function store(Request $employeeStoreRequest, Laundry $laundry)
    {
        if(auth()->id() == $laundry->user_id && auth()->user()->tokenCan('ownerDo')){
            $validator = Validator::make($employeeStoreRequest->all(),[
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

            $employee = User::create(
                [
                    'name'      => $employeeStoreRequest->name,
                    'email'     => $employeeStoreRequest->email,
                    'password'  => bcrypt($employeeStoreRequest->password),
                    'role'      => User::ROLE_EMPLOYEE,
                    'no_hp'     => $employeeStoreRequest->no_hp
                ]
            );
    
            $laundry->employees()->create([
                'user_id' => $employee->id,
            ]);
    
            return UserResource::make($employee);
        }

        return response()->json("Permintaan ditolak");
       
    }

    // public function update(EmployeeUpdateRequest $employeeUpdateRequest, Laundry $laundry, Employee $employee)
    // {
    //     // throw_if(
    //     //     auth()->id() != $laundry->user_id
    //     //         || $laundry->id != $employee->laundry_id,
    //     //     ValidationException::withMessages(['employee' => 'Tidak dapat mengubah karyawan!'])
    //     // );

    //     if(auth()->user()->tokenCan('ownerDo') && auth()->id() == $laundry->user_id && $laundry->id != $employee->laundry_id){
    //         User::where('id', $employee->user_id)
    //             ->update($employeeUpdateRequest->validated());

    //         $employee->load('user');

    //         return EmployeeResource::make($employee);
    //     }
    //     return response()->json("Permintaan ditolak");
    // }

    public function update(Laundry $laundry, Employee $employee)
    {
        // throw_if(
        //     auth()->id() != $laundry->user_id
        //         || $laundry->id != $employee->laundry_id,
        //     ValidationException::withMessages(['employee' => 'Tidak dapat mengubah karyawan!'])
        // );

        if(auth()->user()->tokenCan('ownerDo') && auth()->id() == $laundry->user_id && $laundry->id == $employee->laundry_id){

            $validator = Validator::make(Request()->all(),[
                'name' => 'required|string|max:255',
                'no_hp' => 'required|min:11',
                'status' => 'required|integer'
            ]);

            if($validator->fails()){
                return response()->json([
                    'error' => 'Format Inputan Tidak Sesuai',
                    'message' => $validator->errors()
                ]);
            }
            $employee->update(['status' => request('status')]);
            User::where('id', $employee->user_id)->update(['name'=> request('name'), 'no_hp'=> request('no_hp') ]);

            $employee->load('user');

            return EmployeeResource::make($employee);
        }
        return response()->json("Permintaan ditolak");
    }

    public function destroy(Laundry $laundry, Employee $employee)
    {
        // throw_if(
        //     !auth()->user()->tokenCan('employee.delete')
        //         || auth()->id() != $laundry->user_id
        //         || $laundry->id != $employee->laundry_id,
        //     ValidationException::withMessages(['employee' => 'Tidak dapat menghapus karyawan!'])
        // );

        if(auth()->user()->tokenCan('ownerDo') && auth()->id() == $laundry->user_id && $laundry->id == $employee->laundry_id){
            User::find($employee->user_id)->delete();

            
            return response()->json([
                'success' => true,
                'message' => 'Berhasil Menghapus Karyawan'
            ]);
        }
        return response()->json("Permintaan ditolak");
        
    }
}
