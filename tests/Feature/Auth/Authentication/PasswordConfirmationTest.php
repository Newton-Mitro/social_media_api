<?php

//it('test_confirm_password_screen_can_be_rendered', function () {
//    $user = User::factory()->create();
//
//    $response = $this->actingAs($user)->get('/confirm-password');
//
//    $response->assertStatus(200);
//});
//
//it('test_password_can_be_confirmed', function () {
//    $user = User::factory()->create();
//
//    $response = $this->actingAs($user)->post('/confirm-password', [
//        'password' => 'password',
//    ]);
//
//    $response->assertRedirect();
//    $response->assertSessionHasNoErrors();
//});
//
//it('test_password_is_not_confirmed_with_invalid_password', function () {
//    $user = User::factory()->create();
//
//    $response = $this->actingAs($user)->post('/confirm-password', [
//        'password' => 'wrong-password',
//    ]);
//
//    $response->assertSessionHasErrors();
//});
