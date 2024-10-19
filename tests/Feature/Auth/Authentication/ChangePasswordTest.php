<?php

use Illuminate\Support\Facades\Hash;
use App\Modules\Auth\User\Models\User;
use App\Modules\Auth\Device\Models\Device;


it('requires authentication', function () {
    $response = $this->postJson('/api/auth/password-change', [
        'password' => 'newpassword',
        'password_confirmation' => 'newpassword',
        'old_password' => 'oldpassword',
        'old_password_confirmation' => 'oldpassword',
    ]);

    $response->assertStatus(401); // Unauthorized
});

it('validates request data', function () {
    // Register User
    $user = User::factory()->create([
        'password' => Hash::make('oldpassword')
    ]);

    // Login User
    $loginResponse = $this->post(route('auth.login'), [
        'email' => $user->email,
        'password' => 'oldpassword',
    ]);

    $devices = Device::all();
    $this->assertCount(1, $devices);
    $access_token = json_decode((string) $loginResponse->getContent())->data->access_token;


    $response = $this->withToken($access_token)->postJson('/api/auth/password-change', [
        'password' => 'short', // Invalid password
        'password_confirmation' => 'short',
        'old_password' => '', // Invalid old password
        'old_password_confirmation' => '',
    ]);

    $response->assertStatus(400) // Unprocessable Entity
        ->assertJsonValidationErrors(['password', 'old_password']);
});

it('changes password successfully with valid data', function () {
    // Register User
    $user = User::factory()->create([
        'password' => Hash::make('oldpassword')
    ]);

    // Login User
    $loginResponse = $this->post(route('auth.login'), [
        'email' => $user->email,
        'password' => 'oldpassword',
    ]);

    $devices = Device::all();
    $this->assertCount(1, $devices);
    $access_token = json_decode((string) $loginResponse->getContent())->data->access_token;


    $response = $this->withToken($access_token)->postJson('/api/auth/password-change', [
        'password' => 'newpassword',
        'password_confirmation' => 'newpassword',
        'old_password' => 'oldpassword',
        'old_password_confirmation' => 'oldpassword',
    ]);

    $response->assertStatus(200)
        ->assertJson(['message' => 'Your password has been updated!']);

    // Verify the new password is set correctly
    $this->assertTrue(Hash::check('newpassword', $user->fresh()->password));
});

it('fails to change password with incorrect old password', function () {
    // Register User
    $user = User::factory()->create([
        'password' => Hash::make('oldpassword')
    ]);

    // Login User
    $loginResponse = $this->post(route('auth.login'), [
        'email' => $user->email,
        'password' => 'oldpassword',
    ]);

    $devices = Device::all();
    $this->assertCount(1, $devices);
    $access_token = json_decode((string) $loginResponse->getContent())->data->access_token;

    $response = $this->withToken($access_token)->postJson('/api/auth/password-change', [
        'password' => 'newpassword',
        'password_confirmation' => 'newpassword',
        'old_password' => 'wrongpassword',
        'old_password_confirmation' => 'wrongpassword',
    ]);

    $response->assertStatus(500)
        ->assertJson(['message' => "Password doesn't match"]);
});

it('fails if passwords do not match', function () {
    // Register User
    $user = User::factory()->create([
        'password' => Hash::make('oldpassword')
    ]);

    // Login User
    $loginResponse = $this->post(route('auth.login'), [
        'email' => $user->email,
        'password' => 'oldpassword',
    ]);

    $devices = Device::all();
    $this->assertCount(1, $devices);
    $access_token = json_decode((string) $loginResponse->getContent())->data->access_token;

    $response = $this->withToken($access_token)->postJson('/api/auth/password-change', [
        'password' => 'newpassword',
        'password_confirmation' => 'differentpassword',
        'old_password' => 'oldpassword',
        'old_password_confirmation' => 'oldpassword',
    ]);

    $response->assertStatus(400)
        ->assertJsonValidationErrors(['password']);
});

it('ensures old password confirmation is correct', function () {
    // Register User
    $user = User::factory()->create([
        'password' => Hash::make('oldpassword')
    ]);

    // Login User
    $loginResponse = $this->post(route('auth.login'), [
        'email' => $user->email,
        'password' => 'oldpassword',
    ]);

    $devices = Device::all();
    $this->assertCount(1, $devices);
    $access_token = json_decode((string) $loginResponse->getContent())->data->access_token;

    $response = $this->withToken($access_token)->postJson('/api/auth/password-change', [
        'password' => 'newpassword',
        'password_confirmation' => 'newpassword',
        'old_password' => 'oldpassword',
        'old_password_confirmation' => 'wrongpassword',
    ]);

    $response->assertStatus(400)
        ->assertJsonValidationErrors(['old_password']);
});
