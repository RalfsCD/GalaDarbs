<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use App\Models\Topic;

uses(RefreshDatabase::class);

test('meklē TopicTest sarakstā un uzņem ekrānuzņēmumu', function () {

    Topic::create(['name' => 'TopicTest',  'description' => 'Pārlūkprogrammas Test topic']);
    Topic::create(['name' => '1111', 'description' => 'Pārlūkprogrammas Test topic']);
    Topic::create(['name' => '2222', 'description' => 'Pārlūkprogrammas Test topic']);

    $email = 'lietotajs@example.test';
    $password = 'Parole123!';

    $page = visit('/register');
    $page->fill('name', 'Lietotājs Test')
         ->fill('email', $email)
         ->fill('password', $password)
         ->fill('password_confirmation', $password)
         ->click('form[action$="/register"] button[type="submit"]');

    $page->navigate('/topics')->assertPathIs('/topics');

    $page->fill('#topics-search', 'TopicTest')
         ->click('form[action$="/topics"] button[aria-label="Search"]');

    $page->screenshot(true, 'topics-search-TopicTest.png');
});
