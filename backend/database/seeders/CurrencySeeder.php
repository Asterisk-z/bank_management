<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Currency::create([
            'name' => 'USD',
            'rate' => 1.000000,
            'base' => 'yes',
            'sign' => '$',
            'status' => 'active',
        ]);
        Currency::create([
            'name' => 'EUR',
            'rate' => 1.51,
            'base' => 'no',
            'sign' => '€',
            'status' => 'active',
        ]);

        Currency::create([
            'name' => 'AUD',
            'rate' => 0.640000,
            'base' => 'no',
            'sign' => 'A$',
            'status' => 'active',
        ]);

    }
}
