<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bank::create([
            'name' => 'Bank Of China',
            'swift_code' => 'BKCHCNBJ110',
            'bank_country' => 'China',
            'bank_currency' => 'USD',
            'minimum_transfer_amount' => 50.00,
            'maximum_transfer_amount' => 1000000.00,
            'fixed_charge' => 0.00,
            'charge_in_percentage' => 1.00,
            'descriptions' => '',
            'status' => 'active',
        ]);

        Bank::create([
            'name' => 'Commonwealth Bank',
            'swift_code' => 'CTBAAU2S',
            'bank_country' => 'Australia',
            'bank_currency' => 'AUD',
            'minimum_transfer_amount' => 50.00,
            'maximum_transfer_amount' => 1000000.00,
            'fixed_charge' => 0.00,
            'charge_in_percentage' => 1.00,
            'descriptions' => '',
            'status' => 'active',
        ]);
        Bank::create([
            'name' => 'Australia and New Zealand Banking Group (ANZ)',
            'swift_code' => 'ANZBAU3MXXX',
            'bank_country' => 'Afghanistan',
            'bank_currency' => 'USD',
            'minimum_transfer_amount' => 50.00,
            'maximum_transfer_amount' => 100000.00,
            'fixed_charge' => 0.00,
            'charge_in_percentage' => 1.00,
            'descriptions' => '',
            'status' => 'active',
        ]);
        Bank::create([
            'name' => 'National Australian Bank (NAB)',
            'swift_code' => 'NATAAU3303M',
            'bank_country' => 'Afghanistan',
            'bank_currency' => 'AUD',
            'minimum_transfer_amount' => 50.00,
            'maximum_transfer_amount' => 1000000.00,
            'fixed_charge' => 0.00,
            'charge_in_percentage' => 1.00,
            'descriptions' => '',
            'status' => 'active',
        ]);

        Bank::create([
            'name' => 'Westpac Bank',
            'swift_code' => 'WPACAU2S',
            'bank_country' => 'Australia',
            'bank_currency' => 'AUD',
            'minimum_transfer_amount' => 50.00,
            'maximum_transfer_amount' => 1000000.00,
            'fixed_charge' => 0.00,
            'charge_in_percentage' => 1.00,
            'descriptions' => '',
            'status' => 'active',
        ]);
        Bank::create([
            'name' => 'Bank of Queensland',
            'swift_code' => 'QBANAU4B',
            'bank_country' => 'Afghanistan',
            'bank_currency' => 'AUD',
            'minimum_transfer_amount' => 50.00,
            'maximum_transfer_amount' => 100000.00,
            'fixed_charge' => 0.00,
            'charge_in_percentage' => 1.00,
            'descriptions' => '',
            'status' => 'active',
        ]);
        Bank::create([
            'name' => 'Macquarie Bank',
            'swift_code' => 'MACQAU2S',
            'bank_country' => 'Afghanistan',
            'bank_currency' => 'AUD',
            'minimum_transfer_amount' => 50.00,
            'maximum_transfer_amount' => 100000.00,
            'fixed_charge' => 0.00,
            'charge_in_percentage' => 1.00,
            'descriptions' => '',
            'status' => 'active',
        ]);
        Bank::create([
            'name' => 'Bendigo Bank',
            'swift_code' => 'BENDAU3B',
            'bank_country' => 'Afghanistan',
            'bank_currency' => 'AUD',
            'minimum_transfer_amount' => 50.00,
            'maximum_transfer_amount' => 100000.00,
            'fixed_charge' => 0.00,
            'charge_in_percentage' => 1.00,
            'descriptions' => '',
            'status' => 'active',
        ]);

        Bank::create([
            'name' => 'AMP Bank Ltd',
            'swift_code' => 'AMPBAU2SRET',
            'bank_country' => 'Australia',
            'bank_currency' => 'AUD',
            'minimum_transfer_amount' => 50.00,
            'maximum_transfer_amount' => 1000000.00,
            'fixed_charge' => 0.00,
            'charge_in_percentage' => 1.00,
            'descriptions' => '',
            'status' => 'active',
        ]);
        Bank::create([
            'name' => 'Suncorp Bank',
            'swift_code' => 'METWAU4B',
            'bank_country' => 'Afghanistan',
            'bank_currency' => 'USD',
            'minimum_transfer_amount' => 50.00,
            'maximum_transfer_amount' => 100000.00,
            'fixed_charge' => 0.00,
            'charge_in_percentage' => 1.00,
            'descriptions' => '',
            'status' => 'active',
        ]);

        Bank::create([
            'name' => 'PNC Bank',
            'swift_code' => 'PNCCUS33XXX',
            'bank_country' => 'Afghanistan',
            'bank_currency' => 'USD',
            'minimum_transfer_amount' => 100.00,
            'maximum_transfer_amount' => 1000000.00,
            'fixed_charge' => 0.00,
            'charge_in_percentage' => 1.00,
            'descriptions' => '',
            'status' => 'active',
        ]);

        Bank::create([
            'name' => 'TURKIYE IS BANKASI A.S',
            'swift_code' => 'ISBKTRISXXX',
            'bank_country' => 'Turkey',
            'bank_currency' => 'USD',
            'minimum_transfer_amount' => 100.00,
            'maximum_transfer_amount' => 1000000.00,
            'fixed_charge' => 0.00,
            'charge_in_percentage' => 0.00,
            'descriptions' => '',
            'status' => 'active',
        ]);

    }
}
