<?php

namespace Database\Seeders;

use App\Models\User;
use App\Services\Helper;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->last_name = "Admin";
        $user->first_name = "User";
        $user->phone = "1234567800";
        $user->country_code = "234";
        $user->name = "Admin User";
        $user->email = "admin@royal.com";
        $user->user_type = "admin";
        $user->status = "active";
        $user->password = bcrypt("1qa2ws3ed4rf");
        $user->save();

        $account_number = Helper::generate_account_number();
        $card_number = Helper::generate_card_number();
        $user->account_details()->create(['account_number' => $account_number, 'first_card_number' => $card_number]);

        $user = new User();
        $user->last_name = "Daniel";
        $user->first_name = "User";
        $user->phone = "1234567000";
        $user->country_code = "234";
        $user->name = "Daniel User";
        $user->email = "daniel@royal.com";
        $user->user_type = "customer";
        $user->status = "active";
        $user->password = bcrypt("1qa2ws3ed4rf");
        $user->save();
        $account_number = Helper::generate_account_number();
        $card_number = Helper::generate_card_number();
        $user->account_details()->create(['account_number' => $account_number, 'first_card_number' => $card_number]);
        // $user->account_details->add_balance(300, "USD");
        // $user->account_details->add_balance(30, "USD");

        $user = new User();
        $user->last_name = "Olang";
        $user->first_name = "User";
        $user->phone = "1234560000";
        $user->country_code = "234";
        $user->name = "Olang User";
        $user->email = "olang@royal.com";
        $user->user_type = "customer";
        $user->status = "active";
        $user->password = bcrypt("1qa2ws3ed4rf");
        $user->save();
        $account_number = Helper::generate_account_number();
        $card_number = Helper::generate_card_number();
        $user->account_details()->create(['account_number' => $account_number, 'first_card_number' => $card_number]);

        // $user->account_details->add_balance(1000, "USD");

    }
}
