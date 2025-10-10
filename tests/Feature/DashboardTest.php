<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

uses(RefreshDatabase::class);

test('Lietotājs var reģistrēties', function () {

    //lietotāja reģistrācijas dati
    $email = 'lietotajs@example.test';
    $password = 'Parole123!';

    //Tīmekļa vietnes tests apmeklē reģistrācijas lapu
    $page = visit('/register');

    //Tīmekļa vietnes tests aizpilda reģistrācijas veidlapu un iesniedz to
    $page->fill('name', 'Lietotājs Test')
        ->fill('email', $email)
        ->fill('password', $password)
        ->fill('password_confirmation', $password)
        ->click('button[type=submit]'); 

        $this->assertAuthenticated();
    //Pārbauda, vai lietotājs tiek novirzīts uz "dashboard" sadaļu
    $page->navigate('/dashboard')
        ->assertPathIs('/dashboard')
        ->assertSee('Dashboard');

    //Ekrānuzņēmums pēc veiksmīgas reģistrācijas un novirzīšanas uz "dashboard" sadaļu
    $page->screenshot(true, 'dashboard-after-register.png');
});





