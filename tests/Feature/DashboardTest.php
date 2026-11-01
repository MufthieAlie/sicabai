<?php

use App\Models\User;

test('guests are redirected to the login page', function () {
    $this->get('/dashboard')->assertRedirect('/login');
});

test('regular users cannot visit the dashboard', function () {
    $this->actingAs($user = User::factory()->create());

    $this->get('/dashboard')->assertForbidden();
});

test('admins and experts can visit the dashboard', function () {
    foreach (['admin', 'pakar'] as $role) {
        $user = User::factory()->create();
        $user->forceFill(['role' => $role])->save();

        $this->actingAs($user)->get('/dashboard')->assertOk();
    }
});