<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LaundryStoreRequest;
use App\Models\Laundry;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Parfume;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Laundry $laundry)
    {

        $transactions = Transaction::with('user', 'catalog', 'parfume')
        ->whereBelongsTo($laundry)
        // ->where('status',Transaction::STATUS_FINISHED)
        ->get();

        return view('pages.transaction.index', compact('transactions'));
    }
}
