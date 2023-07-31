<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class CurrencyController extends Controller
{

    public function create_currency(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required',
            'rate' => 'required',
            'sign' => 'required',
            'base_status' => 'required',
            'status' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        DB::beginTransaction();
        $status = request('status');
        if (request('base_status') == 'yes') {
            $currencies = Currency::where('base', 'yes')->get();
            foreach ($currencies as $curr) {
                $curr->base = 'no';
                $curr->save();
            }
            $status = "active";
        }

        Currency::create([
            'name' => request('name'),
            'rate' => request('rate'),
            'sign' => request('sign'),
            'base' => request('base_status'),
            'status' => $status,
        ]);

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => "Currency Created Successfully",
        ], 200);

    }
    public function update_currency(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required',
            'rate' => 'required',
            'sign' => 'required',
            'id' => 'required',
            'base_status' => 'required',
            'status' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        $currency = Currency::where('id', request('id'))->first();
        if (!$currency) {
            return response()->json([
                'status' => false,
                'message' => 'Can Not Find Currency',
            ], 200);

        }

        DB::beginTransaction();
        $status = request('status');
        if (request('base_status') == 'yes') {
            $currencies = Currency::where('base', 'yes')->get();
            foreach ($currencies as $curr) {
                $curr->base = 'no';
                $curr->save();
            }
            $status = "active";
        }
        $currency = Currency::where('id', request('id'))->first();

        $currency->name = request('name');
        $currency->rate = request('rate');
        $currency->sign = request('sign');
        $currency->base = request('base_status');
        $currency->status = $status;
        $currency->save();

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => "Currency Updated Successfully",
        ], 200);

    }

    public function list_currency()
    {
        $currencies = Currency::orderBy('created_at')->get();
        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'currencies' => $currencies,
        ], 200);
    }
    public function list_active_currency()
    {
        $currencies = Currency::where('status', 'active')
            ->orderBy('created_at')->get();
        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'currencies' => $currencies,
        ], 200);
    }

    public function list_not_active_currency()
    {
        $currencies = Currency::where('status', 'not_active')
            ->orderBy('created_at')->get();
        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'currencies' => $currencies,
        ], 200);
    }

    public function single_currency(Request $request)
    {
        $v = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        $currency = Currency::where('id', request('id'))->first();
        if (!$currency) {
            return response()->json([
                'status' => false,
                'message' => 'Can Not FInd Currency',
            ], 200);

        }

        return response()->json([
            'status' => true,
            'message' => 'Upload',
            'currency' => $currency,
        ], 200);

    }
    public function make_base_currency(Request $request)
    {
        $v = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        $currency = Currency::where('id', request('id'))->first();
        if (!$currency) {
            return response()->json([
                'status' => false,
                'message' => 'Unable to Activate',
            ], 200);

        }

        $currencies = Currency::where('base', 'yes')->get();
        foreach ($currencies as $curr) {
            $curr->base = 'no';
            $curr->save();
        }

        $currency = Currency::where('id', request('id'))->first();
        $currency->base = "yes";
        $currency->status = 'active';
        $currency->save();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
        ], 200);

    }

    public function activate_currency(Request $request)
    {
        $v = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        $currency = Currency::where('id', request('id'))->first();
        if (!$currency) {
            return response()->json([
                'status' => false,
                'message' => 'Unable to Activate',
            ], 200);

        }
        if ($currency->status == 'active') {
            return response()->json([
                'status' => false,
                'message' => 'Currency Already Active',
            ], 200);
        }

        $currency->status = 'active';

        $currency->save();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
        ], 200);

    }

    public function deactivate_currency(Request $request)
    {
        $v = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        $currency = Currency::where('id', request('id'))->first();
        if (!$currency) {
            return response()->json([
                'status' => false,
                'message' => 'Unable to Activate',
            ], 200);

        }
        if ($currency->status == 'not_active') {
            return response()->json([
                'status' => false,
                'message' => 'Currency Already canceled',
            ], 200);
        }

        if ($currency->base == 'yes') {
            return response()->json([
                'status' => false,
                'message' => 'Can not Deactivate a base currency',
            ], 200);
        }

        $currency->status = 'not_active';

        $currency->save();

        return response()->json([
            'status' => true,
            'message' => 'Upload',
        ], 200);

    }
}
