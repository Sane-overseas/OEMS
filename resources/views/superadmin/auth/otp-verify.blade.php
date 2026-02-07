<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
            Verify OTP
        </h2>

        <form method="POST" action="{{ route('superadmin.otp.verify') }}" class="space-y-5">
            @csrf

            <!-- OTP Input -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    One-Time Password
                </label>
                <input
                    type="text"
                    name="otp"
                    maxlength="6"
                    placeholder="Enter 6-digit OTP"
                    class="w-full text-center tracking-widest px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >

                @error('otp')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Verify Button -->
            <button
                type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-md font-semibold hover:bg-blue-700 transition duration-200"
            >
                Verify
            </button>
        </form>
    </div>

</body>
</html>
