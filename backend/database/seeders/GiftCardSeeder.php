<?php

namespace Database\Seeders;

use App\Models\GiftCard;
use Illuminate\Database\Seeder;

class GiftCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GiftCard::create([
            'code' => "QAZWSXEDC1",
            'currency' => "USD",
            'amount' => "3000",
            'is_general' => 'yes',
            'status' => 'active',
            'active_till' => now()->addDay(3),
        ]);
        GiftCard::create([
            'code' => "QAZWSXEDC2",
            'currency' => "USD",
            'amount' => "3000",
            'is_general' => 'yes',
            'status' => 'active',
            'active_till' => now(),
        ]);

        GiftCard::create([
            'code' => "QAZWSXEDC2",
            'currency' => "USD",
            'amount' => "3000",
            'is_general' => 'yes',
            'status' => 'active',
            'active_till' => now()->addDay(3),
        ]);
    }
}
