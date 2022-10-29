<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\LaundryResource;
use App\Models\Laundry;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{
    public function index()
    {
        if(auth()->user()->tokenCan('customerDo')){

            $laundries = Laundry::query()
            ->with(['catalogs', 'parfumes', 'shippingRates', 'operationalHour'])
            ->where('status', Laundry::STATUS_ACTIVE)
            ->where('lat','!=',null)
            ->where('lng','!=',null)
            ->nearestTo(request('lat'), request('lng'))
            ->having("distance", "<", 5)
            ->take(8)
            ->get();

            
            return LaundryResource::collection($laundries);
        }

        return response()->json("Permintaan ditolak");
       
    }

}
