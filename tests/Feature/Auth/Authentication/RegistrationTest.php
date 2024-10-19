<?php

use App\Modules\Auth\User\Models\User;
use Illuminate\Http\Response;

describe('Registration', function (): void {

    it('can register new user', function (): void {
        $response = $this->post(route('auth.register'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertStatus(Response::HTTP_CREATED);

        $message = json_decode((string) $response->getContent())->message;

        $users = User::all();
        $this->assertCount(1, $users);
        expect($users[0]->email)->toBe('test@example.com');
        expect($message)->toBe('User registered successfully.');
    });

    it('expects that the user is already exist', function (): void {
        $user = User::factory()->create();

        $response = $this->post(route('auth.register'), [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
        $response->assertExactJson(
            [
                'data' => null,
                'message' => 'User already exist',
                'error' => 'User already exist',
                'errors' => null,
            ]
        );
    });

    it('expects validation errors', function (): void {
        $response = $this->post(route('auth.register'), []);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertExactJson(
            [
                'data' => null,
                'message' => 'The name field is required. (and 2 more errors)',
                'error' => 'The name field is required. (and 2 more errors)',
                'errors' => [
                    'name' => ['The name field is required.'],
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.'],
                ],
            ]
        );
    });
});
