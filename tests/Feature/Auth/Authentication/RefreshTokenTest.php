<?php

use App\Modules\Auth\Device\Models\Device;
use App\Modules\Auth\User\Models\User;
use Illuminate\Http\Response;

describe('RefreshToken', function (): void {

    it('can refresh token', function (): void {
        // Register User
        $user = User::factory()->create();

        // Login User
        $response = $this->post(route('auth.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $refreshToken = json_decode((string) $response->getContent())->data->refresh_token;

        // Refresh Token
        $headers = [
            'Accept: application/json',
            'Authorization: Bearer ' . $refreshToken,
        ];

        $response = $this->withToken($refreshToken)->get(route('auth.refresh'));

        $updatedDevices = Device::all();
        expect($updatedDevices[0]->device_token)->not()->toBe($refreshToken);
    });

    it('expects jwt refresh token', function (): void {
        $response = $this->get(route('auth.refresh'));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $response->assertExactJson(
            [
                'data' => null,
                'message' => 'JWT refresh token required',
                'error' => 'JWT refresh token required',
                'errors' => null,
            ]
        );
    });

    it('expects token signature mismatch', function (): void {
        $invalidToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ0YWZhbGluZ19hcGkiLCJhdWQiOiJodHRwOi8vdGFmYWxpbmcuY29tIiwianRpIjoiNGYxZzIzYTEyYWEiLCJpYXQiOjE3MjQ2Njc0OTkuMTQxNzE1LCJuYmYiOjE3MjQ2Njc1NTkuMTQxNzE1LCJleHAiOjE3MjQ2Njc1NTkuMTQxNzE1LCJzdWIiOiJhY2Nlc3NfdG9rZW4iLCJ1aWQiOiIzZmYwZDU4Yi1lNmUwLTRiYzktYjQ1MC00ODE4YjdiNDBlOWYifQ.j1_fzsX90AXWDpfx_HTY9k7zHp2rWXDY4VEUn15OUTs';

        $response = $this->withToken($invalidToken)->get(route('auth.refresh'));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $response->assertExactJson(
            [
                'data' => null,
                'message' => 'Token signature mismatch.',
                'error' => 'Token signature mismatch.',
                'errors' => null,
            ]
        );
    });

    it('expects token has been expired or revoked', function (): void {
        $invalidToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImZvbyI6ImJhciJ9.eyJpc3MiOiJ0YWZhbGluZ19hcGkiLCJhdWQiOiJodHRwOi8vdGFmYWxpbmcuY29tIiwianRpIjoiNGYxZzIzYTEyYWEiLCJpYXQiOjE3MjQ2NjM4MzguMTM1MTAyLCJuYmYiOjE3MjQ2NjM4OTguMTM1MTAyLCJleHAiOjE3MjQ2NjQxMzguMTM1MTAyLCJzdWIiOiJyZWZyZXNoX3Rva2VuIiwidWlkIjoiYTRmM2QzYTAtZWIwOC00MjQ3LTlkMWUtNWQzYWEzZDQxNGFhIn0.Qg0rX3jkm3fMc59qwfQyZdjztSN-Aa-t8jOvszgyZd4';

        $response = $this->withToken($invalidToken)->get(route('auth.refresh'));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $response->assertExactJson(
            [
                'data' => null,
                'message' => 'Token has been expired or revoked.',
                'error' => 'Token has been expired or revoked.',
                'errors' => null,
            ]
        );
    });

    it('expects invalid token can not be parsed', function (): void {
        $invalidToken = 'eyJ0eXAiOiJKV1QiLCJheHAiOjE3Mj0MjQ3LTlkMWUtNWQzY59qwfQyZdjztSN-Aa-t8jOvszgyZd4';

        $response = $this->withToken($invalidToken)->get(route('auth.refresh'));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $response->assertExactJson(
            [
                'data' => null,
                'message' => "Invalid token, can't be parse token.",
                'error' => "Invalid token, can't be parse token.",
                'errors' => null,
            ]
        );
    });
});
