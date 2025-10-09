<?php

test('example', function () {
    $page = visit('/');

    $page->assertSee('Welcome');


     $page->screenshot(true,  'home.png'); 
});
