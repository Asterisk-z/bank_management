<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // $this->call(UserSeeder::class);
        // $this->call(CurrencySeeder::class);
        // $this->call(BankSeeder::class);
        // $this->call(GiftCardSeeder::class);
        // $this->call(PaymentMethodSeeder::class);
        // $this->call(LoanProducts::class);
        // $this->call(FixedDepositPlanSeeder::class);
        // $this->call(SettingSeeder::class);
        $this->call(KycDocumentSeed::class);

    }
}
