<?php

use function Pest\Laravel\getJson;

it('get response from the web API', function (): void {
    // Arrange

    // Act
    $response = getJson('/');

    // Assert
    $response->assertStatus(200);
});
