<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat atau mengambil role jika sudah ada
        $ownerRole = Role::firstOrCreate(['name' => 'owner']);
        $fundraiserRole = Role::firstOrCreate(['name' => 'fundraiser']);

        // Membuat atau mengambil user owner
        $userOwner = User::firstOrCreate(
            ['email' => 'andikapsw30@gmail.com'], // Cek berdasarkan email agar tidak duplikat
            [
                'name' => 'Andika Fikri',
                'avatar' => 'images/default-avatar.png',
                'password' => Hash::make('123123123123') // Hashing password untuk keamanan
            ]
        );

        // Menetapkan role ke user jika belum ada
        if (!$userOwner->hasRole($ownerRole)) {
            $userOwner->assignRole($ownerRole);
        }
    }
}
