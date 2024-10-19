<?php

use App\Features\Auth\Device\Models\Device;
use App\Features\Auth\User\Models\User;
use Illuminate\Http\Response;

describe('login', function (): void {
    it('can authenticate but email need to be verified', function (): void {
        $user = User::factory()->unverified()->create();
        $response = $this->post(route('auth.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $message = json_decode((string) $response->getContent())->message;
        expect($message)->toBe('Your email address is not verified.');
    });

    it('can authenticate but email is verified', function (): void {
        $user = User::factory()->create();
        $response = $this->post(route('auth.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $message = json_decode((string) $response->getContent())->message;
        expect($message)->toBe('Successfully logged in');
    });

    it('can not authenticate with invalid password', function (): void {
        $user = User::factory()->create();
        $response = $this->post(route('auth.login'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $this->assertGuest();
        $response->assertExactJson(
            [
                'data' => null,
                'message' => 'Invalid email or password.',
                'error' => 'Invalid email or password.',
                'errors' => null,
            ]
        );
    });

    it('expects validation errors', function (): void {
        $response = $this->post(route('auth.login'), []);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertExactJson(
            [
                'data' => null,
                'message' => 'The email field is required. (and 1 more error)',
                'error' => 'The email field is required. (and 1 more error)',
                'errors' => [
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.'],
                ],
            ]
        );
    });

    it('is expected to be a device created', function (): void {
        $user = User::factory()->create();
        $response = $this->post(route('auth.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $devices = Device::all();
        $this->assertCount(1, $devices);
    });
});
