<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login | ExamPlatform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .login-bg {
            background: radial-gradient(at 70% 30%, #3b82f6 0%, #111827 100%);
        }
        .glass-card {
            background: rgba(255,255,255,0.7);
            backdrop-filter: blur(8px);
        }
        .logo-shadow {
            filter: drop-shadow(0 2px 12px rgba(59, 130, 246, 0.25));
        }
    </style>
</head>
<body class="login-bg min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full rounded-2xl shadow-2xl overflow-hidden border border-gray-200 glass-card">
        <div class="px-8 py-10">
            <div class="flex flex-col items-center mb-8">
                <img src="https://cdn-icons-png.flaticon.com/512/3500/3500528.png" alt="Student Portal" class="w-16 h-16 mb-2 logo-shadow">
                <h2 class="text-3xl font-extrabold text-gray-800 mb-1">Welcome, Student</h2>
                <p class="text-gray-600 text-sm">Sign in to access your exams & dashboard</p>
            </div>
            
            @if ($errors->any())
                <div class="mb-5 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm animate-shake">
                    <div class="flex items-start">
                        <svg class="h-5 w-5 text-red-400 mt-[2px]" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <p class="ml-3 text-sm text-red-700 font-medium">{{ $errors->first() }}</p>
                    </div>
                </div>
            @endif

            <form action="{{ route('student.login.submit') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-xs font-semibold text-gray-700 mb-1 ml-1">Email Address</label>
                    <input type="email" name="email" id="email" required autofocus autocomplete="username"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition placeholder-gray-400 text-gray-900 bg-white"
                        placeholder="mahesh@gmail.com" value="{{ old('email') }}">
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-gray-700 mb-1 ml-1">Password</label>
                    <input type="password" name="password" id="password" required autocomplete="current-password"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition placeholder-gray-400 text-gray-900 bg-white"
                        placeholder="••••••••">
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 text-sm text-gray-600 select-none cursor-pointer">Remember me</label>
                    </div>
                    <!-- Disabled for now, feel free to link actual route in future -->
                    <span class="text-sm font-medium text-gray-400 cursor-not-allowed select-none">Forgot password?</span>
                </div>

                <button type="submit" class="w-full flex justify-center py-3 px-4 rounded-lg shadow-md text-base font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400 transition-all">
                    <i class="bi bi-box-arrow-in-right mr-2 text-lg"></i>Sign In
                </button>
            </form>
            <div class="mt-7 text-xs text-gray-400 text-center">
                &copy; {{ date('Y') }} ExamPlatform &mdash; made for students.
            </div>
        </div>
    </div>
    <script>
    // Cute shake animation for error cards
    document.querySelectorAll('.animate-shake').forEach(function(el) {
        el.classList.add('duration-300');
        setTimeout(() => el.classList.remove('animate-shake'), 1000);
    });
    </script>
    <style>
    @keyframes shake { 10%, 90% { transform: translateX(-2px); } 20%, 80% { transform: translateX(4px);} 30%, 50%, 70% { transform: translateX(-8px);} 40%, 60% { transform: translateX(8px);} }
    .animate-shake { animation: shake 0.5s; }
    </style>
    <!-- Bootstrap Icons CDN for login icon -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
