<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use App\Modules\Auth\User\Models\User;
use App\Modules\Auth\Device\Models\Device;


it('successfully updates the profile picture', function () {
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

    $filePath = base_path('tests/assets/erd.png');

    // Create an UploadedFile instance
    $file = new UploadedFile(
        $filePath, // Path to the file
        'profilePhoto.png', // Original name of the file
        'image/png', // MIME type of the file
        null, // File size (null or integer in bytes)
        true // Test flag to simulate a real file upload
    );

    // Perform the POST request
    $response = $this->withToken($access_token)->postJson('/api/user/profile/picture/update', [
        'profilePhoto' => $file,
    ]);

    // Assert the response status is successful
    $response->assertStatus(201);
    // Optionally, assert that the file exists in storage
    // Storage::disk('public')->assertExists('profile_pictures/' . 'profilePhoto.png');
});
