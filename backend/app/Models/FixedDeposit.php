<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedDeposit extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function plan()
    {
        return $this->belongsTo(FixedDepositPlan::class, 'fdr_plan_id')->withDefault();
    }

    public function approved_by()
    {
        return $this->belongsTo(User::class, 'approved_user_id')->withDefault();
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_user_id')->withDefault();
    }

    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_user_id')->withDefault();
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id')->withDefault();
    }
}
