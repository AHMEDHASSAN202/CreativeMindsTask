<?php

namespace Database\Seeders;

use App\Models\VerifyCode;
use Illuminate\Database\Seeder;

class VerifyCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VerifyCode::insert([
            ['user_id'  => 2, 'verify_code' => generateVerifyCode(), 'expired_at' => now()->addMinutes(30)],
            ['user_id'  => 3, 'verify_code' => generateVerifyCode(), 'expired_at' => now()->addMinutes(30)],
        ]);
    }
}
