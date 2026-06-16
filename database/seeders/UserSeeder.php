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
            'id' => 9,
            'name'=>'superadmin',
            'mobile_no' => '9123595538',
            'email'=>'superadmin@gmail.com',
            'password'=>Hash::make('Admin@123')
        ]);
    }
}
