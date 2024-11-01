<?php

namespace App\Http\Controllers;

use App\Models\Kyc;
use App\Models\KycDocument;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class KycController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDocuments()
    {
        $kyc_documents = KycDocument::orderBy('name', 'ASC')->get();

        return response()->json([
            'status' => true,
            'message' => "KYC Documents Fetch Successfully",
            'kyc_documents' => $kyc_documents,
        ], 200);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserKycs()
    {

        return response()->json([
            'status' => true,
            'message' => "KYC Fetch Successfully",
            'kycs' => auth()->user()->kycs,
        ], 200);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAdminUserKycs($id)
    {
        $kycs = Kyc::where('user_id', $id)->get();

        return response()->json([
            'status' => true,
            'message' => "KYC Fetch Successfully",
            'kycs' => $kycs,
        ], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAdminAllKycs()
    {
        $kycs = Kyc::orderBy('name', 'DESC')->get();

        return response()->json([
            'status' => true,
            'message' => "KYC Fetch Successfully",
            'kycs' => $kycs,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadKyc(Request $request)
    {
        $v = Validator::make($request->all(), [
            'kyc_document_id' => 'required',
            'message' => 'sometimes',
            'attachment' => 'required',
        ]);
        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        $kyc_document = KycDocument::where('id', request('kyc_document_id'))->first();

        if (!$kyc_document) {
            return response()->json([
                'status' => false,
                'errors' => "KYC Document Not Available",
            ], 422);

        }

        $attachment = "";
        if ($request->hasfile('attachment')) {
            $file = $request->file('attachment');
            $attachment = time() . $file->getClientOriginalName();
            $file->move(public_path() . "/uploads/kyc_document/", $attachment);
        }

        Kyc::updateOrCreate(['user_id' => auth()->user()->id, 'kyc_document_id' => $kyc_document->id], [
            'kyc_document_id' => $kyc_document->id,
            'attachment' => $attachment,
            'message' => $request['message'],
            'status' => 'pending',
        ]);

        // auth()->user()->notify(new DepositMoneyNotification("Your Deposit Request  of " . $request->currency . " " . $request->amount . " is pending "));

        //EMAIL_REQUIRED
        return response()->json(['status' => true, 'message' => "Kyc Uploaded successfully"]);
    }

    public function actionKyc(Request $request)
    {

        $v = Validator::make($request->all(), [
            'kyc_id' => 'required',
            'status' => 'required|in:accepted,rejected',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $v->errors(),
            ], 422);
        }

        $kyc = Kyc::find(request('kyc_id'));
        $kyc->status = $request->status;
        $kyc->save();

        // Mail::send('emails.status', ['messages' => "Your Withdraw Request of  " . $transaction->currency . " " . $transaction->amount . " to with reference no. " . $transaction->transaction_ref . " is completed successfully  ", 'firstName' => $user->name, 'subject' => "Withdraw Request Completed"], function ($message) use ($request, $user) {
        //     $message->to($user->email);
        //     $message->subject("Withdraw Request Approved");
        // });

        // $user->notify(new WithdrawMoneyApprovedNotification("Your Withdraw Request  with reference no. " . $transaction->transaction_ref . " is completed successfully "));

        return response()->json([
            'status' => true,
            'message' => 'Kyc Actioned Successfully',
        ], 200);

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
