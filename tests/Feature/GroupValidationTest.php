<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use App\Models\Topic;

uses(RefreshDatabase::class);

test('Grupas validācija', function () {
    
    Topic::factory()->count(5)->create();
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
         ->click('form[action$="/register"] button[type="submit"]');

     //Lietotājs tiek novirzīts uz "dashboard" sadaļu
    $page->navigate('/')->assertPathIs('/dashboard');

    //Lietotājs dodas uz grupas izveides lapu
    $page->navigate('/groups/create')->assertPathIs('/groups/create');

    //Neaizpilda ievadlaukus un mēģina iesniegt veidlapu
    $page->click('#createGroupForm button[type="submit"]')

    //Pārbauda, vai tiek parādītas validācijas kļūdas
         ->assertSee('Please fix the following:');

     //Ekrānuzņēmums ar validācijas kļūdām
    $page->screenshot(true, 'groups-create-validation.png');
});






