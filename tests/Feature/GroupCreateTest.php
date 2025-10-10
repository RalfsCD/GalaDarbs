<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use App\Models\Topic;

uses(RefreshDatabase::class);

test('Grupas izveide', function () {
    
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

     //Aizpilda grupas izveides veidlapu un iesniedz to
    $groupName = 'Test';

     //Tiek aizpildīti grupas izveides lauki un izvēlēta tēma
    $page->fill('#name', $groupName)
         ->fill('#description', 'Grupa, kas izveidota pārlūka testā.')
         ->click('#topics-primary .topic-bubble:first-of-type')
         ->click('#createGroupForm button[type="submit"]');

     //Lietotājs tiek novirzīts uz grupu saraksta lapu un redz jauno grupu
    $page->navigate('/groups')->assertPathIs('/groups');

     //Ekrānuzņēmums pēc veiksmīgas grupas izveides un redzamas grupas sarakstā
    $page->screenshot(true, 'groups-index-after-create.png');
});


