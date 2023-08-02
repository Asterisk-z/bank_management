<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Currency;

class CurrencyController extends Controller
{
    //

    public function fetch_currency()
    {
        $currencies = Currency::where('status', 'active')->get();
        return response()->json([
            'status' => true,
            'currencies' => $currencies,
        ], 200);

    }

}
