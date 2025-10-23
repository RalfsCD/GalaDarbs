<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = 'admin@test.lv';
        $password = 'Parole123!';

        $payload = [
            'name'     => 'Administrators',
            'email'    => $email,
            'password' => Hash::make($password),
        ];

        // Create or update the user by email
        $user = User::updateOrCreate(['email' => $email], $payload);

        // If your users table has any of these columns, set them too
        if (Schema::hasColumn($user->getTable(), 'role')) {
            $user->role = 'admin';
        }
        if (Schema::hasColumn($user->getTable(), 'is_admin')) {
            $user->is_admin = true;
        }
        if (Schema::hasColumn($user->getTable(), 'username')) {
            $user->username = $email; // you said "username: admin@test.lv"
        }

        $user->save();
    }
}

