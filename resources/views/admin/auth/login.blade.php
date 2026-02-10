<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Login | ExamPlatform Pro</title>
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

    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
        Admin Login
    </h2>

    <!-- Password Login -->
    <form id="passwordForm" method="POST" action="{{ route('admin.login') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>

            <input type="email" name="email" value="{{ old('email') }}" required
                   class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2
                          focus:outline-none focus:ring-2 focus:ring-indigo-500">

            <!-- small otp button -->
            <button type="button"
                onclick="showOtpForm()"
                class="mt-2 text-sm text-indigo-600 hover:underline font-medium">
                Login with OTP
            </button>

            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" required
                   class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2
                          focus:outline-none focus:ring-2 focus:ring-indigo-500">

            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
                class="w-full bg-indigo-600 text-white py-2 rounded-lg
                       font-semibold hover:bg-indigo-700 transition">
            Login with Password
        </button>
    </form>


    <!-- OTP Login Form (hidden initially) -->
    <form id="otpForm" method="POST" action="{{ route('admin.send.otp') }}" class="space-y-4 hidden mt-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700">Email for OTP</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2
                          focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        <button type="submit"
                class="w-full bg-green-600 text-white py-2 rounded-lg
                       font-semibold hover:bg-green-700 transition">
            Send OTP
        </button>

        <!-- back to password login -->
        <button type="button"
                onclick="showPasswordForm()"
                class="w-full text-sm text-gray-600 hover:underline">
            Back to password login
        </button>
    </form>

</div>


<script>
function showOtpForm() {
    document.getElementById('passwordForm').classList.add('hidden');
    document.getElementById('otpForm').classList.remove('hidden');
}

function showPasswordForm() {
    document.getElementById('otpForm').classList.add('hidden');
    document.getElementById('passwordForm').classList.remove('hidden');
}
</script>

</body>


</html>
