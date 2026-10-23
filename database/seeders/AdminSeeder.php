<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Creates (or resets) the admin account from .env:
 *   ADMIN_NAME, ADMIN_EMAIL, ADMIN_PASSWORD   (see config/admin.php)
 * Change the password from the admin panel after the first login.
 */
class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = config('admin.email');

        User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => config('admin.name'),
                'password' => Hash::make(config('admin.password')),
            ]
        );

        $this->command?->info("Admin: {$email}");
    }
}
