<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
    <style>
        /* Tailwind CSS CDN */
        @import url('https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css');
    </style>
</head>
<body class="bg-gray-100">
    <table role="presentation" class="w-full bg-white">
        <tr>
            <td class="py-6 px-4">
                <div class="max-w-lg mx-auto bg-white p-8 border border-gray-200 rounded-lg shadow-md">
                    <h1 class="text-2xl font-bold text-gray-800 mb-4">Reset Your Password</h1>
                    <p class="text-gray-600 mb-6">Hi {{ $name }},</p>
                    <p class="text-gray-600 mb-6">We received a request to reset your password for your Tafaling account. Please use the One-Time Password (OTP) below to reset your password:</p>
                    
                    <div class="bg-yellow-100 border border-yellow-200 text-yellow-800 text-center py-4 px-6 rounded-lg mb-6">
                        <p class="text-xl font-semibold">Your OTP Code</p>
                        <p class="text-2xl font-bold mt-2">{{ $otp }}</p>
                    </div>

                    <p class="text-gray-600 mb-6">To reset your password, go to the password reset page and enter this OTP code. Please note that this OTP is valid for <strong>{{ $otp_validity_period }} minutes</strong>. If the OTP expires, you'll need to request a new one.</p>
                    
                    <p class="text-gray-600 mb-6">If you did not request a password reset, please disregard this email.</p>
                    
                    <p class="text-gray-600 mb-6">If you have any issues or need further assistance, please reply to this email or visit our <a href="[Support URL]" class="text-blue-600 hover:underline">support page</a>.</p>

                    <p class="text-gray-600 mt-6">Best regards,<br>The Tafaling Team</p>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>