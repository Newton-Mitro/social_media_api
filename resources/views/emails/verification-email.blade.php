<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Verify Your Account</title>
        <style>
            /* Tailwind CSS CDN */
            @import url("https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css");
        </style>
    </head>
    <body class="bg-gray-100">
        <table role="presentation" class="w-full bg-white">
            <tr>
                <td class="py-6 px-4">
                    <div
                        class="max-w-lg mx-auto bg-white p-8 border border-gray-200 rounded-lg shadow-md"
                    >
                        <h1 class="text-2xl font-bold text-gray-800 mb-4">
                            Account Verification
                        </h1>
                        <p class="text-gray-600 mb-6">Hi {{ $name }},</p>
                        <p class="text-gray-600 mb-6">
                            Thank you for registering with Tafaling! To complete
                            your account setup, please verify your email address
                            using the One-Time Password (OTP) below:
                        </p>

                        <div
                            class="bg-blue-100 border border-blue-200 text-blue-800 text-center py-4 px-6 rounded-lg mb-6"
                        >
                            <p class="text-xl font-semibold">Your OTP Code</p>
                            <p class="text-2xl font-bold mt-2">{{ $otp }}</p>
                        </div>
                        <p class="text-gray-600 mb-6">
                            Please note that this OTP is valid for
                            <strong>{{ $otp_validity_period }} minutes</strong>.
                            If the OTP expires, you'll need to request a new
                            one.
                        </p>

                        <p class="text-gray-600 mb-6">
                            Enter this OTP code in the verification page to
                            confirm your email address. If you didn’t create an
                            account, please disregard this email.
                        </p>

                        <p class="text-gray-600 mb-6">
                            If you have any issues or need support, feel free to
                            reply to this email or visit our
                            <a
                                href="[Support URL]"
                                class="text-blue-600 hover:underline"
                                >support page</a
                            >.
                        </p>

                        <p class="text-gray-600 mt-6">
                            Best regards,<br />The Tafaling Team
                        </p>
                    </div>
                </td>
            </tr>
        </table>
    </body>
</html>
