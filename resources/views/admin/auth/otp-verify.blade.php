<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP | ExamPlatform Pro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-600 to-purple-700 px-4">

    <div class="w-full max-w-md bg-white rounded-xl shadow-2xl p-8">

        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
            Verify OTP
        </h2>

        <form method="POST" action="{{ route('admin.verify.otp') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Enter OTP
                </label>
                <input
                    type="text"
                    name="otp"
                    value="{{ old('otp') }}"
                    required
                    maxlength="6"
                    placeholder="6-digit OTP"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 text-center tracking-widest text-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
                @error('otp')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button
                type="submit"
                class="w-full bg-green-600 text-white py-2 rounded-lg font-semibold hover:bg-green-700 transition"
            >
                Verify OTP
            </button>
        </form>

    </div>

</body>
</html>
