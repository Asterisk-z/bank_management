<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function borrower()
    {
        return $this->belongsTo(User::class, 'borrower_id')->withDefault();
    }

    public function loan_product()
    {
        return $this->belongsTo(LoanProduct::class, 'loan_product_id')->withDefault();
    }
}
