<?php

use App\Http\Controllers\Api\V1\{
    UserController, InformationController, RegisterController
};
use App\Http\Controllers\Api\V1\Customer\{
    HomeController, LaundryController as CustomerLaundryController
};
use App\Http\Controllers\Api\V1\Owner\{
    CatalogController, EmployeeController, HomeController as OwnerHomeController, LaundryController, OperationalHourController,
    ParfumeController, ShippingRateController, TransactionController
};
use App\Http\Controllers\Api\V1\Admin\{
    AdminController, InformationController as AdminInformationController, LaundryController as AdminLaundryController
};
use Illuminate\Support\Facades\Route;

Route::post('v1/login',     [UserController::class, 'login']);
Route::post('v1/register',  [RegisterController::class, 'register']);
Route::get('v1/info',       [InformationController::class, 'index']);

Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'v1'], function () {
    Route::group(['prefix' => 'admin'], function () {
        //managing admin
        Route::get('admin',         [AdminController::class, 'index']);
        Route::post('admin',         [AdminController::class, 'store']);
        Route::delete('{admin}',  [AdminController::class, 'destroy']);

        //managing mitra (owner and laundry)
        Route::get('mitra',         [AdminLaundryController::class, 'index']);
        Route::post('mitra',         [AdminLaundryController::class, 'store']);
        Route::put('mitra/{mitra}',  [AdminLaundryController::class, 'status']);
        Route::delete('mitra/{mitra}',  [AdminLaundryController::class, 'destroy']);

        //managing informations
        Route::get('info',         [AdminInformationController::class, 'index']);
        Route::post('info',         [AdminInformationController::class, 'store']);
        Route::put('info/{information}',         [AdminInformationController::class, 'status']);
        Route::delete('info/{information}',         [AdminInformationController::class, 'destroy']);
    });

    Route::group(['prefix' => 'owner'], function () {
        // Managing Employees...
        Route::get('laundries/{laundry}/employees',                         [EmployeeController::class, 'index']);
        Route::post('laundries/{laundry}/employees',                        [EmployeeController::class, 'store']);
        Route::put('laundries/{laundry}/employees/{employee}',              [EmployeeController::class, 'update']);
        Route::delete('laundries/{laundry}/employees/{employee}',           [EmployeeController::class, 'destroy']);

        // Managing Parfumes...
        Route::get('laundries/{laundry}/parfumes',                          [ParfumeController::class, 'index']);
        Route::post('laundries/{laundry}/parfumes',                         [ParfumeController::class, 'store']);
        Route::put('laundries/{laundry}/parfumes/{parfume}',                [ParfumeController::class, 'update']);
        Route::delete('laundries/{laundry}/parfumes/{parfume}',             [ParfumeController::class, 'destroy']);

        // Managing Service Catalog...
        Route::get('laundries/{laundry}/catalogs',               [CatalogController::class, 'index']);
        Route::post('laundries/{laundry}/catalogs',              [CatalogController::class, 'store']);
        Route::put('laundries/{laundry}/catalogs/{catalog}',     [CatalogController::class, 'update']);
        Route::delete('laundries/{laundry}/catalogs/{catalog}',  [CatalogController::class, 'destroy']);

        // Managing Shipping Rate...
        Route::get('laundries/{laundry}/shipping',                         [ShippingRateController::class, 'index']);
        Route::post('laundries/{laundry}/shipping',                        [ShippingRateController::class, 'store']);
        Route::put('laundries/{laundry}/shipping/{shippingRate}',       [ShippingRateController::class, 'update']);
        Route::delete('laundries/{laundry}/shipping/{shippingRate}',       [ShippingRateController::class, 'destroy']);

        // Update Profile Laundry
        Route::post('laundries/{laundry}/update',                 [LaundryController::class, 'update']);
        Route::put('laundries/{laundry}/updatecondition',        [LaundryController::class, 'updateCondition']);

        // Managing Operational Hour
        Route::get('laundries/{laundry}/operationalhour',        [OperationalHourController::class, 'index']);
        Route::put('laundries/{laundry}/operationalhour/{operationalHour}',  [OperationalHourController::class, 'update']);
        Route::put('laundries/{laundry}/operationalhour',  [OperationalHourController::class, 'updateAll']);

        // Home Owner 
        Route::get('laundries/{laundry}/home',      OwnerHomeController::class);

        // Update Status Transaction
        Route::post('laundries/{laundry}/transaction/{transaction}',    [TransactionController::class, 'update']);
        Route::put('laundries/{laundry}/transaction/export',    [TransactionController::class, 'export']);
        Route::delete('laundries/{laundry}/transaction/{transaction}',       [TransactionController::class, 'destroy']);
    });

    Route::group(['prefix' => 'customer'], function () {
        Route::get('laundries',         [HomeController::class, 'index']);
        Route::get('laundries/transaction',         [CustomerLaundryController::class, 'index']);
        Route::post('laundries/{laundry}/store',    [CustomerLaundryController::class, 'store']); 
    });


    Route::put('profile',    [UserController::class, 'update']);
    Route::post('logout',    [UserController::class, 'logout']);
});
