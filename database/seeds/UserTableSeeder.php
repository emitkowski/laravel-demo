<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{

    public function run()
    {
        $factory = factory(User::class);

        if (!User::where('email', 'eric@demo.com')->exists()) {
            $factory->create(['first_name' => 'Eric', 'last_name' => 'Mitkowski', 'email' => 'eric@demo.com', 'approved_at' => now()]);
        }
    }

}