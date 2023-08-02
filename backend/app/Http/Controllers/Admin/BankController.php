<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;
use Validator;

class BankController extends Controller
{
    //
    public function create_bank(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'swift_code' => 'required',
            'minimum_transfer_amount' => 'required|numeric',
            'maximum_transfer_amount' => 'required|numeric',
            'bank_country' => 'required',
            'bank_currency' => 'required',
            'fixed_charge' => 'required|numeric',
            'charge_in_percentage' => 'required|numeric',
            'descriptions' => '',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $bank = new Bank();
        $bank->name = $request->input('name');
        $bank->swift_code = $request->input('swift_code');
        $bank->bank_country = $request->input('bank_country');
        $bank->bank_currency = $request->input('bank_currency');
        $bank->minimum_transfer_amount = $request->input('minimum_transfer_amount');
        $bank->maximum_transfer_amount = $request->input('maximum_transfer_amount');
        $bank->fixed_charge = $request->input('fixed_charge');
        $bank->charge_in_percentage = $request->input('charge_in_percentage');
        $bank->descriptions = $request->input('descriptions');
        $bank->status = $request->input('status');

        $bank->save();

        return response()->json([
            'status' => true,
            'message' => "Bank  Created Successfully",
        ], 200);

    }
    public function update_bank(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
            'swift_code' => 'required',
            'minimum_transfer_amount' => 'required|numeric',
            'maximum_transfer_amount' => 'required|numeric',
            'bank_country' => 'required',
            'bank_currency' => 'required',
            'fixed_charge' => 'required|numeric',
            'charge_in_percentage' => 'required|numeric',
            'descriptions' => '',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        $bank = Bank::where('id', request('id'))->first();

        if (!$bank) {
            return response()->json([
                'status' => false,
                'errors' => "Bank Not Found",
            ], 422);
        }

        $bank->name = $request->input('name');
        $bank->swift_code = $request->input('swift_code');
        $bank->bank_country = $request->input('bank_country');
        $bank->bank_currency = $request->input('bank_currency');
        $bank->minimum_transfer_amount = $request->input('minimum_transfer_amount');
        $bank->maximum_transfer_amount = $request->input('maximum_transfer_amount');
        $bank->fixed_charge = $request->input('fixed_charge');
        $bank->charge_in_percentage = $request->input('charge_in_percentage');
        $bank->descriptions = $request->input('descriptions');
        $bank->status = $request->input('status');

        $bank->save();

        return response()->json([
            'status' => true,
            'message' => "Bank  Updated Successfully",
        ], 200);

    }

    public function bank_activate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        $bank = Bank::where('id', request('id'))->first();

        if (!$bank) {
            return response()->json([
                'status' => false,
                'errors' => "Bank Not Found",
            ], 422);
        }

        $bank->status = 'active';
        $bank->save();

        return response()->json([
            'status' => true,
            'message' => "Bank Activated Successfully",
            'bank' => $bank,
        ], 200);

    }

    public function bank_deactivate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        $bank = Bank::where('id', request('id'))->first();

        if (!$bank) {
            return response()->json([
                'status' => false,
                'errors' => "Bank Not Found",
            ], 422);
        }

        $bank->status = 'not_active';
        $bank->save();

        return response()->json([
            'status' => true,
            'message' => "Bank Deactivated Successfully",
            'bank' => $bank,
        ], 200);

    }
    public function get_bank(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bank_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        $bank = Bank::where('id', request('bank_id'))->first();

        if (!$bank) {
            return response()->json([
                'status' => false,
                'errors' => "Bank Not Found",
            ], 422);
        }

        return response()->json([
            'status' => true,
            'message' => "Bank Found Successfully",
            'bank' => $bank,
        ], 200);

    }

    public function list_banks(Request $request)
    {
        $banks = Bank::orderBy('created_at')->get();

        return response()->json([
            'status' => true,
            'message' => "Bank Found Successfully",
            'banks' => $banks,
        ], 200);

    }

    public function list_active_bank(Request $request)
    {
        $banks = Bank::where('status', 'active')->orderBy('created_at')->get();

        return response()->json([
            'status' => true,
            'message' => "Bank Found Successfully",
            'banks' => $banks,
        ], 200);

    }

    public function list_not_active_bank(Request $request)
    {
        $banks = Bank::where('status', 'not_active')->orderBy('created_at')->get();

        return response()->json([
            'status' => true,
            'message' => "Bank Found Successfully",
            'banks' => $banks,
        ], 200);

    }
}
