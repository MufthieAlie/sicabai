<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('users:assign-role {email} {role}', function (string $email, string $role) {
    if (! in_array($role, ['admin', 'pakar', 'user'], true)) {
        $this->error('Role harus berupa admin, pakar, atau user.');

        return 1;
    }

    $user = User::where('email', $email)->firstOrFail();
    $user->forceFill(['role' => $role])->save();
    $this->info("Role {$role} berhasil diberikan kepada {$email}.");

    return 0;
})->purpose('Set a user role');
