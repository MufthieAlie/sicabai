<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'mufthiealie01@gmail.com'],
            [
                'name' => 'mufthiealie01',
                'password' => Hash::make('Tasik.01'),
                'email_verified_at' => now(),
                'role' => 'admin',
            ]
        );

        $this->call([
            SistemPakarSeeder::class,
        ]);
    }
}
