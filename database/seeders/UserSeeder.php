<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::insert([
            ['username'  => 'username', 'password' => password_hash('password', PASSWORD_DEFAULT), 'mobile' => '201096206374', 'mobile_verified_at' => now()],
            ['username'  => 'username1', 'password' => password_hash('password', PASSWORD_DEFAULT), 'mobile' => '201096206373', 'mobile_verified_at' => null],
            ['username'  => 'username2', 'password' => password_hash('password', PASSWORD_DEFAULT), 'mobile' => '201096206375', 'mobile_verified_at' => null],
        ]);

        User::insert([
            'username' => 'admin',
            'password' => password_hash('password', PASSWORD_DEFAULT),
            'mobile' => '201096206370',
            'mobile_verified_at' => now(),
            'role'  => 'admin'
        ]);
    }
}
