<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use App\Models\Topic;

uses(RefreshDatabase::class);

test('Grupas izveide', function () {
    
    Topic::factory()->count(5)->create();

    $email = 'lietotajs@example.test';
    $password = 'Parole123!';

    $page = visit('/register');
    $page->fill('name', 'Lietotājs Test')
         ->fill('email', $email)
         ->fill('password', $password)
         ->fill('password_confirmation', $password)
         ->click('form[action$="/register"] button[type="submit"]');

    $page->navigate('/')->assertPathIs('/dashboard');

    $page->navigate('/groups/create')->assertPathIs('/groups/create');

    $groupName = 'Test';

    $page->fill('#name', $groupName)
         ->fill('#description', 'Grupa, kas izveidota pārlūka testā.')
         ->click('#topics-primary .topic-bubble:first-of-type')
         ->click('#createGroupForm button[type="submit"]');

    $page->navigate('/groups')->assertPathIs('/groups');

    $page->screenshot(true, 'groups-index-after-create.png');
});
