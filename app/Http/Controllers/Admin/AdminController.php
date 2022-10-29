<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminStoreRequest;
use App\Models\Laundry;
use App\Models\User;
use App\Models\Parfume;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
      $admin = User::where('role',1)
      ->get();

     return view('pages.admin.index', compact('admin'));
    }

    public function detail(User $admin)
    {
        return view('pages.admin.detail', compact('admin'));
    }


    public function create()
    {
        return view('pages.admin.create');
    }




    public function store(AdminStoreRequest $AdminStoreRequest)
    {
        $user = User::create([
            'name' => $AdminStoreRequest->name,
            'email' => $AdminStoreRequest->email,
            'password' => bcrypt($AdminStoreRequest->password),
            'no_hp' => $AdminStoreRequest->no_hp,
            'role' => User::ROLE_ADMIN
        ]);

        return redirect()->route('admin.admin.index');
    }

    public function destroy(User $admin)
    {
        User::find($admin->id)->delete();

        return redirect()->route('admin.admin.index');
    }

    
    // public function status(Request $request, Laundry $laundry)
    // {
    //     $laundry->update(['status' => $request->status]);

    //     return redirect()->route('admin.laundries.index');
    // }
}
