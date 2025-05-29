<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id' => 1,
            'name'=>'Admin',
            'mobile_no' => '6677889910',
            'email'=>'admin@gmail.com',
            'password'=>Hash::make('Admin@123')
        ]);
    }
}
