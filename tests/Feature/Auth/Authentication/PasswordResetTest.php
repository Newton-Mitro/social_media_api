<?php

//it('test_reset_password_link_screen_can_be_rendered', function () {
//    $response = $this->get('/forgot-password');
//
//    $response->assertStatus(200);
//});
//
//it('test_reset_password_link_can_be_requested', function () {
//    Notification::fake();
//
//    $user = User::factory()->create();
//
//    $this->post('/forgot-password', ['email' => $user->email]);
//
//    Notification::assertSentTo($user, ResetPassword::class);
//});
//
//it('test_reset_password_screen_can_be_rendered', function () {
//    Notification::fake();
//
//    $user = User::factory()->create();
//
//    $this->post('/forgot-password', ['email' => $user->email]);
//
//    Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
//        $response = $this->get('/reset-password/' . $notification->token);
//
//        $response->assertStatus(200);
//
//        return true;
//    });
//});
//
//it('test_password_can_be_reset_with_valid_token', function () {
//    Notification::fake();
//
//    $user = User::factory()->create();
//
//    $this->post('/forgot-password', ['email' => $user->email]);
//
//    Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
//        $response = $this->post('/reset-password', [
//            'token' => $notification->token,
//            'email' => $user->email,
//            'password' => 'password',
//            'password_confirmation' => 'password',
//        ]);
//
//        $response->assertSessionHasNoErrors();
//
//        return true;
//    });
//});
