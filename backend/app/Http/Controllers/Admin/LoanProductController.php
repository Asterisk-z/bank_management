<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoanProduct;
use Illuminate\Http\Request;
use Validator;

class LoanProductController extends Controller
{
    public function create_loan_product(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'minimum_amount' => 'required|numeric',
            'maximum_amount' => 'required|numeric',
            'interest_rate' => 'required|numeric',
            'interest_type' => 'required',
            'term' => 'required|integer',
            'term_period' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->all()]);
        }

        $loanproduct = new LoanProduct();
        $loanproduct->name = $request->input('name');
        $loanproduct->minimum_amount = $request->minimum_amount;
        $loanproduct->maximum_amount = $request->maximum_amount;
        $loanproduct->description = $request->input('description');
        $loanproduct->interest_rate = $request->input('interest_rate');
        $loanproduct->interest_type = $request->input('interest_type');
        $loanproduct->term = $request->input('term');
        $loanproduct->term_period = $request->input('term_period');
        $loanproduct->status = $request->input('status');

        $loanproduct->save();

        return response()->json(['status' => true, 'message' => "Loan Product Created Successful"]);

    }
    public function update_loan_product(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
            'minimum_amount' => 'required|numeric',
            'maximum_amount' => 'required|numeric',
            'interest_rate' => 'required|numeric',
            'interest_type' => 'required',
            'term' => 'required|integer',
            'term_period' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->all()]);
        }

        $loan_product = LoanProduct::where('id', request('id'))->first();

        if (!$loan_product) {
            return response()->json(['status' => false, 'message' => "Loan Product Not Avaliable"]);
        }

        $loan_product->name = $request->input('name');
        $loan_product->minimum_amount = $request->minimum_amount;
        $loan_product->maximum_amount = $request->maximum_amount;
        $loan_product->description = $request->input('description');
        $loan_product->interest_rate = $request->input('interest_rate');
        $loan_product->interest_type = $request->input('interest_type');
        $loan_product->term = $request->input('term');
        $loan_product->term_period = $request->input('term_period');
        $loan_product->status = $request->input('status');

        $loan_product->save();

        return response()->json(['status' => true, 'message' => "Loan Product Updated Successful"]);

    }

    public function get_loan_product(Request $request)
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
        $loan_product = LoanProduct::where('id', request('id'))->first();

        if (!$loan_product) {
            return response()->json([
                'status' => false,
                'errors' => "loan_product Not Found",
            ], 422);
        }

        return response()->json([
            'status' => true,
            'message' => "loan_product Found Successfully",
            'loan_product' => $loan_product,
        ], 200);

    }
    public function all_loan_product()
    {
        $loan_products = LoanProduct::orderBy('created_at')->get();
        return response()->json([
            'status' => true,
            'message' => "loan Products Found Successfully",
            'loan_products' => $loan_products,
        ], 200);
    }
    public function fetch_products()
    {
        $loan_products = LoanProduct::where('status', 'active')->orderBy('created_at')->get();
        return response()->json([
            'status' => true,
            'message' => "loan Products Found Successfully",
            'loan_products' => $loan_products,
        ], 200);

    }
    public function all_active_loan_product()
    {
        $loan_products = LoanProduct::where('status', 'active')->orderBy('created_at')->get();
        return response()->json([
            'status' => true,
            'message' => "loan Products Found Successfully",
            'loan_products' => $loan_products,
        ], 200);
    }
    public function all_not_active_loan_product()
    {
        $loan_products = LoanProduct::where('status', 'not_active')->orderBy('created_at')->get();
        return response()->json([
            'status' => true,
            'message' => "loan Products Found Successfully",
            'loan_products' => $loan_products,
        ], 200);
    }
    public function activate_loan_product(Request $request)
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
        $loan_product = LoanProduct::where('id', request('id'))->first();

        if (!$loan_product) {
            return response()->json([
                'status' => false,
                'errors' => "loan product Not Found",
            ], 422);
        }

        $loan_product->status = 'active';
        $loan_product->save();

        return response()->json([
            'status' => true,
            'message' => "Loan Product Activated Successfully",
            'loan_product' => $loan_product,
        ], 200);

    }
    public function deactivate_loan_product(Request $request)
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
        $loan_product = LoanProduct::where('id', request('id'))->first();

        if (!$loan_product) {
            return response()->json([
                'status' => false,
                'errors' => "loan product Not Found",
            ], 422);
        }

        $loan_product->status = 'not_active';
        $loan_product->save();

        return response()->json([
            'status' => true,
            'message' => "Loan Product Deactivated Successfully",
            'loan_product' => $loan_product,
        ], 200);

    }
}
