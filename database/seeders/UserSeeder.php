<?php

namespace Database\Seeders;

use App\Infrastructure\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Beyazıt Kölemen',
            'email' => 'beyazit@artf4.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
        ]);


    }
}
