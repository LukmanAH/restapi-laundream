<?php

namespace App\Http\Controllers\Admin;
use App\Models\Laundry;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {       
        return view('pages.dashboard.index');
    }
}
