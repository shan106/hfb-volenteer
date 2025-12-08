<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@ehb.be',
            ],
            [
                'name'      => 'Admin',
                'username'  => 'admin',
                'password'  => Hash::make('Password!321'),
                'birthday'  => null,
                'about'     => 'Default admin user for the HFB volunteers platform.',
                'avatar_path' => null,
                'is_admin'  => true,
            ]
        );
    }
}
