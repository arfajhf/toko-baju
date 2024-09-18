<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'kode' => '10011',
            'username' => 'admin',
            'password' => 'password',
            'roles' => 'admin'
        ]);

        User::create([
            'kode' => '10012',
            'username' => 'inventaris',
            'password' => 'password',
            'roles' => 'inventaris'
        ]);

        User::create([
            'kode' => '10013',
            'username' => 'kasir',
            'password' => 'password',
            'roles' => 'kasir'
        ]);
    }
}
