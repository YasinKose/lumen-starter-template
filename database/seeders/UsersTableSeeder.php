<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => "Yasin",
            'surname' => "Köse",
            'email' => "yasin.kose.123@gmail.com",
            'password' => Hash::make("123456789aA?")
        ]);
    }
}
