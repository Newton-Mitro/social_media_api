<?php

use App\Modules\Auth\Device\Models\Device;
use App\Modules\Auth\User\Models\User;
use Illuminate\Http\Response;

describe('Logout', function (): void {

    it('expects unauthorized request', function (): void {
        $response = $this->get(route('auth.logout'));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $response->assertExactJson(
            [
                'data' => null,
                'message' => 'JWT access token required',
                'error' => 'JWT access token required',
                'errors' => null,
            ]
        );
    });

    it('expects token signature mismatch', function (): void {
        $invalidToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImZvbyI6ImJhciJ9.eyJpc3MiOiJ0YWZhbGluZ19hcGkiLCJhdWQiOiJodHRwOi8vdGFmYWxpbmcuY29tIiwianRpIjoiNGYxZzIzYTEyYWEiLCJpYXQiOjE3MjQ2NjM4MzguMTM1MTAyLCJuYmYiOjE3MjQ2NjM4OTguMTM1MTAyLCJleHAiOjE3MjQ2NjQxMzguMTM1MTAyLCJzdWIiOiJyZWZyZXNoX3Rva2VuIiwidWlkIjoiYTRmM2QzYTAtZWIwOC00MjQ3LTlkMWUtNWQzYWEzZDQxNGFhIn0.Qg0rX3jkm3fMc59qwfQyZdjztSN-Aa-t8jOvszgyZd4';

        $response = $this->withToken($invalidToken)->get(route('auth.logout'));
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

    it('expects invalid token can not be parsed', function (): void {
        $invalidToken = 'eyJ0eXAiOiJKV1QiLCJheHAiOjE3Mj0MjQ3LTlkMWUtNWQzYWEzZDQxNGFhIn0.Qg0rX3jkm3fMc59qwfQyZdjztSN-Aa-t8jOvszgyZd4';

        $response = $this->withToken($invalidToken)->get(route('auth.logout'));
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

    it('expects successful logout', function (): void {
        // Register User
        $user = User::factory()->create();

        // Login User
        $response = $this->post(route('auth.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $devices = Device::all();
        $this->assertCount(1, $devices);
        $access_token = json_decode((string) $response->getContent())->data->access_token;

        $response = $this->withToken($access_token)->get(route('auth.logout'));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertExactJson(
            [
                'data' => null,
                'message' => 'Successfully logged out',
                'errors' => null,
            ]
        );

        $updateDevices = Device::all();
        $this->assertCount(0, $updateDevices);
    });
});
