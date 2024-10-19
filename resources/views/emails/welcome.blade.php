<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Tafaling</title>
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
                <h1 class="text-2xl font-bold text-gray-800 mb-4">Welcome to Tafaling!</h1>
                <p class="text-gray-600 mb-6">Hi {{ $name }},</p>
                <p class="text-gray-600 mb-6">Thank you for joining Tafaling, the place where your social media experience comes to life. We're excited to have you with us and can’t wait for you to explore all the great features we have to offer.</p>
                <p class="text-gray-600 mb-6">To get started, click the button below to log in and set up your profile:</p>
                <a href="[Login URL]" class="inline-block bg-blue-600 text-white py-2 px-4 rounded-lg text-center no-underline hover:bg-blue-700">Log In</a>
                <p class="text-gray-600 mt-6">If you have any questions or need support, feel free to reply to this email or visit our <a href="[Support URL]" class="text-blue-600 hover:underline">support page</a>.</p>
                <p class="text-gray-600 mt-6">Best regards,<br>The Tafaling Team</p>
            </div>
        </td>
    </tr>
</table>
</body>
</html>
