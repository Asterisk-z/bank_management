<?php

namespace Database\Seeders;

use App\Models\FixedDepositPlan;
use Illuminate\Database\Seeder;

class FixedDepositPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FixedDepositPlan::create([
            'name' => "Inheritance",
            'minimum_amount' => 10.00,
            'maximum_amount' => 99999999.99,
            'interest_rate' => 8.00,
            'duration' => 17,
            'duration_type' => 'month',
        ]);

        FixedDepositPlan::create([
            'name' => "Inheritance Two",
            'minimum_amount' => 500.00,
            'maximum_amount' => 99999999.99,
            'interest_rate' => 15.00,
            'duration' => 9,
            'duration_type' => 'month',
        ]);

        FixedDepositPlan::create([
            'name' => "Inheritance Three",
            'minimum_amount' => 100.00,
            'maximum_amount' => 99999999.99,
            'interest_rate' => 15.00,
            'duration' => 2,
            'duration_type' => 'year',
        ]);

    }
}
