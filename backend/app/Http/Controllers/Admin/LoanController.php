<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\LoanCollateral;
use App\Models\LoanPayment;
use App\Models\LoanRepayment;
use App\Models\Transaction;
use App\Models\User;
use App\Services\Calculator;
use App\Services\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class LoanController extends Controller
{
    public function create_loan_product(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'loan_product_id' => 'required',
            'borrower_id' => 'required',
            'currency' => 'required',
            'first_payment_date' => 'required',
            'release_date' => 'required',
            'applied_amount' => 'required|numeric',
            'late_payment_penalties' => 'required|numeric',
            'attachment' => 'nullable|mimes:jpeg,JPEG,png,PNG,jpg,doc,pdf,docx,zip',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->all()]);
        }

        $attachment = "";
        if ($request->hasfile('attachment')) {
            $file = $request->file('attachment');
            $attachment = time() . $file->getClientOriginalName();
            $file->move(public_path() . "/uploads/loans/", $attachment);
        }

        DB::beginTransaction();
        $loan_ref = Helper::generate_loan_ref();
        $loan = new Loan();
        $loan->loan_ref = $loan_ref;
        $loan->loan_product_id = $request->input('loan_product_id');
        $loan->borrower_id = $request->input('borrower_id');
        $loan->currency = $request->input('currency');
        $loan->first_payment_date = $request->input('first_payment_date');
        $loan->release_date = $request->input('release_date');
        $loan->applied_amount = $request->input('applied_amount');
        $loan->late_payment_penalties = $request->input('late_payment_penalties');
        $loan->attachment = $attachment;
        $loan->description = $request->input('description');
        $loan->remarks = $request->input('remarks');
        $loan->created_user_id = auth()->user()->id;
        $loan->branch_id = auth()->user()->branch_id;

        $loan->save();

        $calculator = new Calculator(
            $loan->applied_amount,
            $loan->first_payment_date,
            $loan->loan_product->interest_rate,
            $loan->loan_product->term,
            $loan->loan_product->term_period,
            $loan->late_payment_penalties
        );

        if ($loan->loan_product->interest_type == 'flat_rate') {
            $repayments = $calculator->get_flat_rate();
        } else if ($loan->loan_product->interest_type == 'fixed_rate') {
            $repayments = $calculator->get_fixed_rate();
        } else if ($loan->loan_product->interest_type == 'mortgage') {
            $repayments = $calculator->get_mortgage();
        } else if ($loan->loan_product->interest_type == 'one_time') {
            $repayments = $calculator->get_one_time();
        }

        $loan->total_payable = $calculator->payable_amount;
        $loan->save();

        DB::commit();

        return response()->json(['status' => true, 'message' => "Loan Product Created Successful"]);

    }
    public function update_loan_product(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'loan_product_id' => 'required',
            'borrower_id' => 'required',
            'currency' => 'required',
            'first_payment_date' => 'required',
            'release_date' => 'required',
            'applied_amount' => 'required|numeric',
            'late_payment_penalties' => 'required|numeric',
            'attachment' => 'nullable|mimes:jpeg,JPEG,png,PNG,jpg,doc,pdf,docx,zip',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->all()]);
        }

        $loan = Loan::where('id', request('id'))->where('status', 'pending')->first();

        if (!$loan) {
            return response()->json(['status' => false, 'message' => "Loan Not Available"]);
        }

        if ($request->hasfile('attachment')) {
            $file = $request->file('attachment');
            $attachment = time() . $file->getClientOriginalName();
            $file->move(public_path() . "/uploads/media/", $attachment);
        }

        DB::beginTransaction();

        $loan = Loan::where('id', request('id'))->where('status', 'pending')->first();
        $loan->loan_product_id = $request->input('loan_product_id');
        $loan->borrower_id = $request->input('borrower_id');
        $loan->currency = $request->input('currency');
        $loan->first_payment_date = $request->input('first_payment_date');
        $loan->release_date = $request->input('release_date');
        $loan->applied_amount = $request->input('applied_amount');
        $loan->late_payment_penalties = $request->input('late_payment_penalties');
        if ($request->hasfile('attachment')) {
            $loan->attachment = $attachment;
        }
        $loan->description = $request->input('description');
        $loan->remarks = $request->input('remarks');

        $loan->save();

        $calculator = new Calculator(
            $loan->applied_amount,
            $loan->first_payment_date,
            $loan->loan_product->interest_rate,
            $loan->loan_product->term,
            $loan->loan_product->term_period,
            $loan->late_payment_penalties
        );

        if ($loan->loan_product->interest_type == 'flat_rate') {
            $repayments = $calculator->get_flat_rate();
        } else if ($loan->loan_product->interest_type == 'fixed_rate') {
            $repayments = $calculator->get_fixed_rate();
        } else if ($loan->loan_product->interest_type == 'mortgage') {
            $repayments = $calculator->get_mortgage();
        } else if ($loan->loan_product->interest_type == 'one_time') {
            $repayments = $calculator->get_one_time();
        }

        $loan->total_payable = $calculator->payable_amount;
        $loan->save();

        DB::commit();

        return response()->json(['status' => true, 'message' => "Loan Product Updated Successful"]);

    }
    public function single_loan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'loan_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        $loan = Loan::where('id', request('loan_id'))->first();

        if (!$loan) {
            return response()->json([
                'status' => false,
                'errors' => "Loan Not Found",
            ], 422);
        }

        $loan_collaterals = LoanCollateral::where('loan_id', $loan->id)
            ->orderBy("id", "desc")
            ->get();

        $repayments = LoanRepayment::where('loan_id', $loan->id)->get();

        $payments = LoanPayment::where('loan_id', $loan->id)->orderBy('id', 'desc')->get();

        return response()->json([
            'status' => true,
            'message' => "loan Found Successfully",
            'data' => [
                "loan" => $loan,
                "loan_collaterals" => $loan_collaterals,
                "repayments" => $repayments,
                "payments" => $payments,
            ],
        ], 200);

    }

    public function single_editable_loan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'loan_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        $loan = Loan::where('id', request('loan_id'))->where('status', 'pending')->first();

        if (!$loan) {
            return response()->json([
                'status' => false,
                'errors' => "Loan Not Found",
            ], 422);
        }

        $loan_collaterals = LoanCollateral::where('loan_id', $loan->id)
            ->orderBy("id", "desc")
            ->get();

        $repayments = LoanRepayment::where('loan_id', $loan->id)->get();

        $payments = LoanPayment::where('loan_id', $loan->id)->orderBy('id', 'desc')->get();

        return response()->json([
            'status' => true,
            'message' => "loan Found Successfully",
            'data' => [
                "loan" => $loan,
                "loan_collaterals" => $loan_collaterals,
                "repayments" => $repayments,
                "payments" => $payments,
            ],
        ], 200);

    }

    public function accept_loan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'loan_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        $loan = Loan::where('id', request('loan_id'))->where('status', 'pending')->first();

        if (!$loan) {
            return response()->json([
                'status' => false,
                'errors' => "Loan Not Found",
            ], 422);
        }

        $user = User::where('id', $loan->borrower_id)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'errors' => "Loan Not Found",
            ], 422);
        }

        $loan->status = 'approved';
        $loan->approved_date = date('Y-m-d');
        $loan->approved_user_id = auth()->user()->id;
        $loan->save();
        DB::beginTransaction();

        $calculator = new Calculator(
            $loan->applied_amount,
            $loan->getRawOriginal('first_payment_date'),
            $loan->loan_product->interest_rate,
            $loan->loan_product->term,
            $loan->loan_product->term_period,
            $loan->late_payment_penalties
        );

        if ($loan->loan_product->interest_type == 'flat_rate') {
            $repayments = $calculator->get_flat_rate();
        } else if ($loan->loan_product->interest_type == 'fixed_rate') {
            $repayments = $calculator->get_fixed_rate();
        } else if ($loan->loan_product->interest_type == 'mortgage') {
            $repayments = $calculator->get_mortgage();
        } else if ($loan->loan_product->interest_type == 'one_time') {
            $repayments = $calculator->get_one_time();
        }

        $loan->total_payable = $calculator->payable_amount;
        $loan->save();

        foreach ($repayments as $repayment) {
            $loan_repayment = new LoanRepayment();
            $loan_repayment->loan_id = $loan->id;
            $loan_repayment->repayment_date = $repayment['date'];
            $loan_repayment->amount_to_pay = $repayment['amount_to_pay'];
            $loan_repayment->penalty = $repayment['penalty'];
            $loan_repayment->principal_amount = $repayment['principle_amount'];
            $loan_repayment->interest = $repayment['interest'];
            $loan_repayment->balance = $repayment['balance'];
            $loan_repayment->save();
        }

        $transaction = new Transaction();
        $transaction->user_id = $loan->borrower_id;
        $transaction->currency = $loan->currency;
        $transaction->amount = $loan->applied_amount;
        $transaction->process = 'credit';
        $transaction->type = 'loan';
        $transaction->method = 'manual';
        $transaction->status = 'approved';
        $transaction->description = 'Loan Approved';
        $transaction->notify = 'Loan Request of ' . $loan->currency . " " . $loan->applied_amount . " was approved";
        $transaction->loan_ref = $loan->loan_ref;

        $transaction->save();

        DB::commit();

        $loan_collaterals = LoanCollateral::where('loan_id', $loan->id)
            ->orderBy("id", "desc")
            ->get();

        $repayments = LoanRepayment::where('loan_id', $loan->id)->get();

        $payments = LoanPayment::where('loan_id', $loan->id)->orderBy('id', 'desc')->get();

        return response()->json([
            'status' => true,
            'message' => "loan Found Successfully",
            'data' => [
                "loan" => $loan,
                "loan_collaterals" => $loan_collaterals,
                "repayments" => $repayments,
                "payments" => $payments,
            ],
        ], 200);

    }

    public function decline_loan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'loan_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        $loan = Loan::where('id', request('loan_id'))->where('status', 'pending')->first();

        if (!$loan) {
            return response()->json([
                'status' => false,
                'errors' => "Loan Not Found",
            ], 422);
        }

        $loan->status = 'declined';
        $loan->save();

        return response()->json([
            'status' => true,
            'message' => "Loan Declined Successfully",
            "loan" => $loan,
        ], 200);

    }

    public function list_loans()
    {

        $loans = Loan::select('loans.*')
            ->with('borrower')
        // ->with('currency')
            ->with('loan_product')
            ->orderBy("loans.id", "desc")->get();

        return response()->json([
            'status' => true,
            'message' => "Loan Found Successfully",
            'loans' => $loans,
        ], 200);

    }

    public function list_active_loans()
    {

        $loans = Loan::select('loans.*')
            ->with('borrower')
        // ->with('currency')
            ->with('loan_product')
            ->orderBy("loans.id", "desc")->get();

        return response()->json([
            'status' => true,
            'message' => "Loan Found Successfully",
            'loans' => $loans,
        ], 200);

    }

    public function list_not_active_loans()
    {

        $loans = Loan::select('loans.*')
            ->with('borrower')
        // ->with('currency')
            ->with('loan_product')
            ->orderBy("loans.id", "desc")->get();

        return response()->json([
            'status' => true,
            'message' => "Loan Found Successfully",
            'loans' => $loans,
        ], 200);

    }

    public function calculate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'apply_amount' => 'required|numeric',
            'interest_rate' => 'required',
            'interest_type' => 'required',
            'term' => 'required|integer|max:100',
            'term_period' => $request->interest_type == 'one_time' ? '' : 'required',
            'late_payment_penalties' => 'required',
            'first_payment_date' => 'required',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            } else {
                return redirect()->route('loans.admin_calculator')->withErrors($validator)->withInput();
            }
        }

        $first_payment_date = $request->first_payment_date;
        $apply_amount = $request->apply_amount;
        $interest_rate = $request->interest_rate;
        $interest_type = $request->interest_type;
        $term = $request->term;
        $term_period = $request->term_period;
        $late_payment_penalties = $request->late_payment_penalties;

        $data = array();
        $table_data = array();

        if ($interest_type == 'flat_rate') {

            $calculator = new Calculator($apply_amount, $first_payment_date, $interest_rate, $term, $term_period, $late_payment_penalties);
            $table_data = $calculator->get_flat_rate();
            $data['payable_amount'] = $calculator->payable_amount;

        } else if ($interest_type == 'fixed_rate') {

            $calculator = new Calculator($apply_amount, $first_payment_date, $interest_rate, $term, $term_period, $late_payment_penalties);
            $table_data = $calculator->get_fixed_rate();
            $data['payable_amount'] = $calculator->payable_amount;

        } else if ($interest_type == 'mortgage') {

            $calculator = new Calculator($apply_amount, $first_payment_date, $interest_rate, $term, $term_period, $late_payment_penalties);
            $table_data = $calculator->get_mortgage();
            $data['payable_amount'] = $calculator->payable_amount;

        } else if ($interest_type == 'one_time') {

            $calculator = new Calculator($apply_amount, $first_payment_date, $interest_rate, 1, $term_period, $late_payment_penalties);
            $table_data = $calculator->get_one_time();
            $data['payable_amount'] = $calculator->payable_amount;

        }

        $data['table_data'] = $table_data;
        $data['first_payment_date'] = $request->first_payment_date;
        $data['apply_amount'] = $request->apply_amount;
        $data['interest_rate'] = $request->interest_rate;
        $data['interest_type'] = $request->interest_type;
        $data['term'] = $request->term;
        $data['term_period'] = $request->term_period;
        $data['late_payment_penalties'] = $request->late_payment_penalties;

        return response()->json([
            'status' => true,
            'message' => "Loan Calculated Successfully",
            'data' => $data,
        ], 200);

    }

    public function list_loan_collaterals(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'loan_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $loancollaterals = LoanCollateral::where('loan_id', request('loan_id'))
            ->orderBy("id", "desc")
            ->get();

        return response()->json([
            'status' => true,
            'message' => "Loan Found Successfully",
            'loancollaterals' => $loancollaterals,
        ], 200);

    }
    public function create_loan_collateral(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'loan_id' => 'required',
            'name' => 'required',
            'collateral_type' => 'required',
            'serial_number' => '',
            'estimated_price' => 'required|numeric',
            'attachments' => 'nullable|mimes:jpeg,png,jpg,doc,pdf,docx,zip',
            'description' => '',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->all()]);
        }

        $attachments = "";
        if ($request->hasfile('attachments')) {
            $file = $request->file('attachments');
            $attachments = time() . $file->getClientOriginalName();
            $file->move(public_path() . "/uploads/loans/", $attachments);
        }

        DB::beginTransaction();

        $loancollateral = new LoanCollateral();
        $loancollateral->loan_id = $request->input('loan_id');
        $loancollateral->name = $request->input('name');
        $loancollateral->collateral_type = $request->input('collateral_type');
        $loancollateral->serial_number = $request->input('serial_number');
        $loancollateral->estimated_price = $request->input('estimated_price');
        $loancollateral->attachments = $attachments;
        $loancollateral->description = $request->input('description');

        $loancollateral->save();

        DB::commit();

        return response()->json(['status' => true, 'message' => "Loan Collateral Created Successful"]);

    }
    public function update_loan_collateral(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
            'collateral_type' => 'required',
            'serial_number' => '',
            'estimated_price' => 'required|numeric',
            'attachments' => 'nullable|mimes:jpeg,png,jpg,doc,pdf,docx,zip',
            'description' => '',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->all()]);
        }

        $loancollateral = LoanCollateral::where('id', request('id'))->first();

        if ($loancollateral) {
            return response()->json(['status' => false, 'message' => "Not Found"]);
        }

        $attachments = "";
        if ($request->hasfile('attachments')) {
            $file = $request->file('attachments');
            $attachments = time() . $file->getClientOriginalName();
            $file->move(public_path() . "/uploads/loans/", $attachments);
        }

        DB::beginTransaction();

        $loancollateral = LoanCollateral::where('id', request('id'))->first();
        $loancollateral->name = $request->input('name');
        $loancollateral->collateral_type = $request->input('collateral_type');
        $loancollateral->serial_number = $request->input('serial_number');
        $loancollateral->estimated_price = $request->input('estimated_price');
        if ($request->hasfile('attachments')) {
            $loancollateral->attachments = $attachments;
        }
        $loancollateral->description = $request->input('description');

        $loancollateral->save();

        DB::commit();

        return response()->json(['status' => true, 'message' => "Loan Collateral Created Successful"]);

    }
    public function destroy_loan_collateral($id)
    {
        $loancollateral = LoanCollateral::find($id);
        $loancollateral->delete();
        return back()->with('success', _lang('Deleted successfully'));
    }
    public function single_loan_collateral(Request $request)
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

        $loancollaterals = LoanCollateral::where('loan_id', request('id'))->First();

        return response()->json([
            'status' => true,
            'message' => "Loan Found Successfully",
            'loancollaterals' => $loancollaterals,
        ], 200);

    }
    public function list_loan_repayments(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'loan_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->all()]);
        }

        $repayments = LoanRepayment::where('loan_id', request('loan_id'))
            ->where('status', 0)
            ->get();
        return response()->json([
            'status' => true,
            'message' => "Loan Found Successfully",
            'repayments' => $repayments,
        ], 200);

    }
    public function list_loan_payments(Request $request)
    {

        $loanpayments = LoanPayment::select('loan_payments.*')
            ->with('loan')
            ->orderBy("loan_payments.id", "desc")->get();

        return response()->json([
            'status' => true,
            'message' => "Loan Found Successfully",
            'loanpayments' => $loanpayments,
        ], 200);

    }
    public function create_loan_payment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'loan_id' => 'required',
            'paid_at' => 'required',
            'late_penalties' => 'nullable|numeric',
            'amount_to_pay' => 'required|numeric',
            'due_amount_of' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->all()]);
        }

        DB::beginTransaction();

        $repayment = LoanRepayment::find($request->due_amount_of);
        $loan = Loan::find($request->loan_id);

        $loanpayment = new LoanPayment();
        $loanpayment->loan_id = $request->loan_id;
        $loanpayment->paid_at = $request->paid_at;
        $loanpayment->late_penalties = $request->late_penalties;
        $loanpayment->interest = $repayment->interest;
        $loanpayment->amount_to_pay = $repayment->amount_to_pay;
        $loanpayment->remarks = $request->remarks;
        $loanpayment->repayment_id = $repayment->id;
        $loanpayment->user_id = auth()->id();

        $loanpayment->save();
        $repayment->status = 1;
        $repayment->save();

        $loan->total_paid = $loan->total_paid + $repayment->amount_to_pay;
        if ($loan->total_paid >= $loan->applied_amount) {
            $loan->status = 2;
        }
        $loan->save();
        DB::commit();

        return response()->json(['status' => true, 'message' => "Loan Collateral Created Successful"]);

    }
    public function destroy($id)
    {
        DB::beginTransaction();

        $loan = Loan::find($id);

        $loancollaterals = LoanCollateral::where('loan_id', $loan->id);
        $loancollaterals->delete();

        $repayments = LoanRepayment::where('loan_id', $loan->id);
        $repayments->delete();

        $loanpayment = LoanPayment::where('loan_id', $loan->id);
        $loanpayment->delete();

        $transaction = Transaction::where('loan_id', $loan->id);
        $transaction->delete();

        $loan->delete();

        DB::commit();
    }
}
