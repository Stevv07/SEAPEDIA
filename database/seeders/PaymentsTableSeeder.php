<?php

namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('payments')->insert([
            [
                'category' => 'Bank',
                'method_name' => 'Bank BNI',
                'account_name' => 'E-TechnoCart',
                'account_number' => '991043589',
                'logo_path' => 'image/bni.png',
            ],
            [
                'category' => 'Bank',
                'method_name' => 'Bank Mandiri',
                'account_name' => 'E-TechnoCart',
                'account_number' => '123456789',
                'logo_path' => 'image/mandiri.png',
            ],
            [
                'category' => 'E-Wallet',
                'method_name' => 'DANA',
                'account_name' => 'E-TechnoCart',
                'account_number' => '08123456789',
                'logo_path' => 'image/dana.png',
            ],
            [
                'category' => 'E-Wallet',
                'method_name' => 'OVO',
                'account_name' => 'E-TechnoCart',
                'account_number' => '08234567890',
                'logo_path' => 'image/ovo.png',
            ],
        ]);
    }
}
