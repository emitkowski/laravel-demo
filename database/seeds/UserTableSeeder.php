<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{

    public function run()
    {
        $factory = factory(User::class);

        if (!User::where('email', 'admin@demo.com')->exists()) {
            $factory->create(['first_name' => 'Demo', 'last_name' => 'User', 'email' => 'admin@demo.com']);
        }
    }

}