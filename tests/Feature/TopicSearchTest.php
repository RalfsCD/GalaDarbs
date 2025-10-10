<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use App\Models\Topic;

uses(RefreshDatabase::class);

test('lietotājs var meklēt tēmu', function () {

    $email = 'lietotajs@example.test';
    $password = 'Parole123!';

    $page = visit('/register');
    $page->fill('name', 'Lietotājs Test')
         ->fill('email', $email)
         ->fill('password', $password)
         ->fill('password_confirmation', $password)
         ->click('form[action$="/register"] button[type="submit"]');

     //Tiek izveidotas 3 tēmas, lai pārbaudītu meklēšanu
     Topic::create(['name' => 'TopicTest',  'description' => 'Pārlūkprogrammas Test topic']);
     Topic::create(['name' => '1111', 'description' => 'Pārlūkprogrammas Test topic']);
     Topic::create(['name' => '2222', 'description' => 'Pārlūkprogrammas Test topic']);

     //Lietotājs dodas uz tēmu saraksta sadaļu
    $page->navigate('/topics')->assertPathIs('/topics');

     //Lietotājs meklē tēmu ar nosaukumu "TopicTest"
    $page->fill('#topics-search', 'TopicTest')
         ->click('form[action$="/topics"] button[aria-label="Search"]');

     //Pārbauda, vai meklēšanas rezultātos redzama tēma "TopicTest"
    $page->assertSee('TopicTest');

     //Ekrānuzņēmums ar meklēšanas rezultātiem
    $page->screenshot(true, 'topics-search-TopicTest.png');
});




