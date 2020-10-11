<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'dilshod',
                'username' => 'dilshod',
                'email' => 'don@gmail.com',
                'password' => '$2y$10$b.kgAdWiu7iMoD/3CKODSuLLkI0o0ikOOf1gTdCF1A5dEPA0ITSjG',
                'created_at' => '2020-10-06 08:47:06',
                'updated_at' => '2020-10-06 08:47:06'
            ],
            [
                'name' => 'ali',
                'username' => 'ali',
                'email' => 'ali@gmail.com',
                'password' => '$2y$10$b.kgAdWiu7iMoD/3CKODSuLLkI0o0ikOOf1gTdCF1A5dEPA0ITSjG',
                'created_at' => '2020-10-06 08:47:06',
                'updated_at' => '2020-10-06 08:47:06'
            ]
        ]);
    }
}
