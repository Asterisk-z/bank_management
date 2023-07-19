<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentMethod::create([
            'name' => 'Payoneer',
            'image' => 'Payoneer_rebrands.jpg',
            'currency_id' => '1',
            'minimum_amount' => '50.00',
            'maximum_amount' => '10000.00',
            'fixed_charge' => '0.00',
            'charge_in_percentage' => '1.00',
            'descriptions' => 'Bank Transfer\r\nWithdraw Limit ($50.00 - $1,000.00)\r\nWithdraw Charge ($0.00 + 1.00%)',
            'status' => 'active',
            'requirements' => '',
            'type' => 'withdrawal',
        ]);
        PaymentMethod::create([
            'name' => 'Plaid',
            'image' => 'plaid-01-1.jpg',
            'currency_id' => '1',
            'minimum_amount' => '100.00',
            'maximum_amount' => '10000000.00',
            'fixed_charge' => '0.00',
            'charge_in_percentage' => '3.00',
            'descriptions' => 'Withdraw Limit ($100.00 - $10,000.00)\r\nWithdraw Charge ($0.00 + 3.00%)',
            'status' => 'active',
            'requirements' => '',
            'type' => 'withdrawal',
        ]);
        PaymentMethod::create([
            'name' => 'Payoneer',
            'image' => 'Payoneer_rebrands.jpg',
            'currency_id' => '1',
            'minimum_amount' => '50.00',
            'maximum_amount' => '10000000.00',
            'fixed_charge' => '0.00',
            'charge_in_percentage' => '1.00',
            'descriptions' => 'Withdraw Limit ($50.00 - $10,000.00)\r\nWithdraw Charge ($0.00 + 1.00%)',
            'status' => 'active',
            'requirements' => '',
            'type' => 'deposit',
            'process' => 'manual',
        ]);
        PaymentMethod::create([
            'name' => 'PayPal',
            'image' => 'paypal.png',
            'currency_id' => '1',
            'minimum_amount' => '10.00',
            'maximum_amount' => '100000.00',
            'fixed_charge' => '0',
            'charge_in_percentage' => '2',
            'descriptions' => '',
            'status' => 'active',
            'requirements' => '',
            'type' => 'deposit',
            'process' => 'automatic',
        ]);
        PaymentMethod::create([
            'name' => 'BitCoin',
            'image' => 'bitcoin.png',
            'currency_id' => '1',
            'minimum_amount' => '50.00',
            'maximum_amount' => '1000000',
            'fixed_charge' => '0',
            'charge_in_percentage' => '1',
            'descriptions' => '',
            'status' => 'active',
            'requirements' => '',
            'type' => 'deposit',
            'process' => 'automatic',
        ]);
    }
}
