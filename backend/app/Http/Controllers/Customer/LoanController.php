<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\LoanProduct;
use App\Services\Calculator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class LoanController extends Controller
{
    public function list_loan_products()
    {
        $products = LoanProduct::where('status', 'active')->get();
        return response()->json([
            'status' => true,
            'message' => "Loan Products List Updated Successfully",
            'products' => $products,
        ], 200);

    }

    public function my_loans()
    {

        return response()->json([
            'status' => true,
            'message' => "Loan List Updated Successfully",
            'data' => auth()->user()->loans,
        ], 200);

    }

    public function loan_request(Request $request)
    {

        $v = Validator::make($request->all(), [
            'applied_amount' => 'required',
            'description' => 'required',
            'loan_product' => 'required',
            'currency' => 'required',
            'first_payment_date' => 'required',
            'attachment' => 'nullable||mimes:jpeg,png,jpg,doc,pdf,docx,zip',
        ]);
        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        $attachment = "";
        if ($request->hasfile('attachment')) {
            $file = $request->file('attachment');
            $attachment = time() . $file->getClientOriginalName();
            $file->move(public_path() . "/uploads/loan_document/", $attachment);
        }

        $loan = Loan::create([
            'loan_ref' => rand(1000000, 9999999),
            'loan_product_id' => $request->loan_product,
            'borrower_id' => auth()->user()->id,
            'currency' => $request->currency,
            'first_payment_date' => Carbon::create($request->first_payment_date),
            'applied_amount' => $request->applied_amount,
            'late_payment_penalties' => 0,
            'attachment' => $attachment,
            'description' => $request->description,
            'remarks' => $request->remarks,
            'created_user_id' => auth()->id(),
            'total_payable' => 0,
        ]);

        $cal = new Calculator(
            $loan->applied_amount,
            $request->first_payment_date,
            $loan->loan_product->interest_rate,
            $loan->loan_product->term,
            $loan->loan_product->term_period,
            $loan->late_payment_penalties
        );

        if ($loan->loan_product->interest_type == 'flat_rate') {
            $repayments = $cal->get_flat_rate();
        } else if ($loan->loan_product->interest_type == 'fixed_rate') {
            $repayments = $cal->get_fixed_rate();
        } else if ($loan->loan_product->interest_type == 'mortgage') {
            $repayments = $cal->get_mortgage();
        } else if ($loan->loan_product->interest_type == 'one_time') {
            $repayments = $cal->get_one_time();
        }

        $loan->total_payable = $cal->payable_amount;
        $loan->save();

        return response()->json([
            'status' => true,
            'message' => "Loan Created Successfully",
            'data' => $loan,
        ], 200);

    }

    public function calculator(Request $request)
    {
        if ($request->isMethod('get')) {
            $data = array();
            $data['first_payment_date'] = '';
            $data['apply_amount'] = '';
            $data['interest_rate'] = '';
            $data['interest_type'] = '';
            $data['term'] = '';
            $data['term_period'] = '';
            $data['late_payment_penalties'] = 0;
            return view('backend.customer_portal.loan.calculator', $data);
        } else if ($request->isMethod('post')) {
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
                    return redirect()->route('loans.calculator')->withErrors($validator)->withInput();
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

            return view('backend.customer_portal.loan.calculator', $data);
        }
    }

    public function loan_payment(Request $request, $loan_id)
    {
        if (request()->isMethod('get')) {
            $loan = Loan::where('id', $loan_id)->where('borrower_id', auth()->id())->first();
            return view('backend.customer_portal.loan.payment', compact('loan'));
        } else if (request()->isMethod('post')) {

            DB::beginTransaction();

            $loan = Loan::where('id', $loan_id)->where('borrower_id', auth()->id())->first();
            $repayment = $loan->next_payment;

            //Create Transaction
            $penalty = date('Y-m-d') > $repayment->repayment_date ? $repayment->penalty : 0;
            $amount = $repayment->amount_to_pay + $penalty;

            //Check Available Balance
            if (get_account_balance($loan->currency_id) < $amount) {
                return back()->with('error', ('Insufficient balance !'));
            }

            //Create Debit Transactions
            $debit = new Transaction();
            $debit->user_id = auth()->id();
            $debit->currency_id = $loan->currency_id;
            $debit->amount = $amount;
            $debit->dr_cr = 'dr';
            $debit->type = 'Loan_Repayment';
            $debit->method = 'Online';
            $debit->status = 2;
            $debit->note = ('Loan Repayment');
            $debit->created_user_id = auth()->id();
            $debit->branch_id = auth()->user()->branch_id;
            $debit->loan_id = $loan->id;

            $debit->save();

            $loanpayment = new LoanPayment();
            $loanpayment->loan_id = $loan->id;
            $loanpayment->paid_at = date('Y-m-d');
            $loanpayment->late_penalties = $penalty;
            $loanpayment->interest = $repayment->interest;
            $loanpayment->amount_to_pay = $repayment->amount_to_pay;
            $loanpayment->remarks = $request->remarks;
            $loanpayment->transaction_id = $debit->id;
            $loanpayment->repayment_id = $repayment->id;
            $loanpayment->user_id = auth()->id();

            $loanpayment->save();

            //Update Loan Balance
            $repayment->status = 1;
            $repayment->save();

            $loan->total_paid = $loan->total_paid + $repayment->amount_to_pay;
            if ($loan->total_paid >= $loan->applied_amount) {
                $loan->status = 2;
            }
            $loan->save();

            DB::commit();

            if (!$request->ajax()) {
                return redirect()->route('loans.my_loans')->with('success', ('Payment Made Sucessfully'));
            } else {
                return response()->json(['result' => 'success', 'action' => 'store', 'message' => ('Payment Made Sucessfully'), 'data' => $loanpayment, 'table' => '#loan_payments_table']);
            }
        }
    }
}
