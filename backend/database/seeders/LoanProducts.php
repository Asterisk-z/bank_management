<?php

namespace Database\Seeders;

use App\Models\LoanProduct;
use Illuminate\Database\Seeder;

class LoanProducts extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LoanProduct::create([
            'name' => "Student Loan",
            "minimum_amount" => 100.00,
            "maximum_amount" => 1000.00,
            "description" => "description",
            "interest_rate" => 5.00,
            "interest_type" => "flat_rate",
            "term" => 24,
            "term_period" => "+1 month",
            "status" => "active",
        ]);

        LoanProduct::create([
            'name' => "Business Loan",
            "minimum_amount" => 1000.00,
            "maximum_amount" => 100000.00,
            "description" => "description",
            "interest_rate" => 12.00,
            "interest_type" => "mortgage",
            "term" => 12,
            "term_period" => "+1 month",
            "status" => "active",
        ]);
        LoanProduct::create([
            'name' => "Enterprise Loan",
            "minimum_amount" => 5000.00,
            "maximum_amount" => 50000.00,
            "description" => "description",
            "interest_rate" => 12.00,
            "interest_type" => "mortgage",
            "term" => 36,
            "term_period" => "+1 month",
            "status" => "active",
        ]);

    }
}
