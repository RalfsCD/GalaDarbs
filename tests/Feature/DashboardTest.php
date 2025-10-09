<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

uses(RefreshDatabase::class);

test('Lietotājs var reģistrēties', function () {

    $email = 'lietotajs@example.test';
    $password = 'Parole123!';

    $page = visit('/register');

    $page->fill('name', 'Lietotājs Test')
        ->fill('email', $email)
        ->fill('password', $password)
        ->fill('password_confirmation', $password)
        ->click('button[type=submit]'); 

        $this->assertAuthenticated();

    $page->navigate('/dashboard')
        ->assertPathIs('/dashboard')
        ->assertSee('Dashboard');

    $page->screenshot(true, 'dashboard-after-register.png');
});
