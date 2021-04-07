<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(Transaction $transaction)
    {
        // dd($transaction->details[0]->product);

        return view('checkout', ['transaction' => $transaction]);
    }
}
