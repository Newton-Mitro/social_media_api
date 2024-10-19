<?php

use Pest\Laravel;
use App\Services\QueryBus;
use App\Services\CommandBus;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use App\Queries\FindUserByEmailQuery;
use App\Features\Auth\User\Models\User;
use App\Commands\SendEmailVerifyingOTPCommand;
use Illuminate\Foundation\Testing\RefreshDatabase;

beforeEach(function () {
    // You might want to set up some initial conditions or mock data
    $this->user = User::factory()->create();

    // Login User
    $response = $this->post(route('auth.login'), [
        'email' => $this->user->email,
        'password' => 'password',
    ]);

    $this->access_token = json_decode((string) $response->getContent())->data->access_token;
});

it('can resend verification email if user is found and OTP is expired', function () {
    $email = $this->user->email;

    // Mock the queryBus and commandBus
    // $this->mock(QueryBus::class)
    //     ->shouldReceive('ask')
    //     ->withArgs(fn($query) => $query instanceof FindUserByEmailQuery && $query->getEmail() === $email)
    //     ->andReturn($this->user);

    // $this->mock(CommandBus::class)
    //     ->shouldReceive('dispatch')
    //     ->withArgs(fn($command) => $command instanceof SendEmailVerifyingOTPCommand && $command->email === $email)
    //     ->andReturn(true);

    // Make a POST request to the endpoint
    $this->withToken($this->access_token)->postJson('/api/account/email/resend', [
        'Content-Type' => 'application/json',
    ])
        ->assertStatus(Response::HTTP_OK);

    // You can add further assertions to ensure the expected behavior
});
