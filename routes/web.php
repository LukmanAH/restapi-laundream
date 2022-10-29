<?php

use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\Admin\LaundryController;

use App\Http\Controllers\Admin\InformationController;

use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true ]);

Route::redirect('/admin', '/login');

Route::redirect('/', '/login');

// Route::get('/', function () {
//     return view("layouts/landingpage");
// });

Route::get('test', function () {
    $now = now()->addDays(6)->locale('id')->dayName;

    return $now;
});

Route::get('login',     [LoginController::class, 'showLoginForm']);
Route::post('login',    [LoginController::class, 'login'])->name('login');


Route::group(['middleware' => ['auth', 'admin.web'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/dashboard',     DashboardController::class)->name('dashboard');

    // Route::get('laundries/new',   [LaundryController::class, 'new'])->name('laundries.new');

    
    // Route::get('/admin',   [AdminController::class, 'index'])->name('admin.index');

    Route::resource('admin',                AdminController::class)->except(['show']);

    //Route::post('admin/{admin}/detail',   [AdminController::class, 'detail'])->name('admin.detail');


    Route::resource('informations',                InformationController::class)->except(['show']);

    Route::post('informations/{information}/status',   [InformationController::class, 'status'])->name('informations.status');

    Route::post('informations/{information}/update',   [InformationController::class, 'update'])->name('informations.edit');


    Route::post('laundries/{laundry}/status',   [LaundryController::class, 'status'])->name('laundries.status');

    Route::resource('laundries',                LaundryController::class)->except(['show']);

    Route::post('laundries/{laundry}/detail',   [LaundryController::class, 'detail'])->name('laundries.detail');

    
    // Route::get('transactions/{laundry}',                [TransactionController::class, 'index']);


    Route::post('logout',   [LoginController::class, 'logout'])->name('logout');
});
