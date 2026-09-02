<?php

it('shows the landing page to guests', function () {
    $response = $this->get('/');

    $response->assertOk();
    $response->assertSee('AI-powered maternal health support for frontline health workers');
});
