<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PaperVault</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/js/app.js'])
    </head>
    <body class="antialiased font-sans bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center">
        <div class="w-full max-w-2xl mx-auto p-8 bg-white/90 rounded-xl shadow-lg flex flex-col items-center">
            <div class="flex items-center gap-3 mb-6">
                <svg class="h-12 w-12 text-indigo-600" fill="none" viewBox="0 0 48 48" stroke="currentColor" stroke-width="2">
                    <rect x="8" y="12" width="32" height="28" rx="4" fill="#6366f1" stroke="#6366f1"/>
                    <rect x="14" y="6" width="20" height="12" rx="2" fill="#fff" stroke="#6366f1"/>
                </svg>
                <span class="text-3xl font-extrabold text-indigo-700 tracking-tight">PaperVault</span>
            </div>
            <h2 class="text-xl text-gray-700 font-semibold mb-4 text-center">Your secure, simple, and smart file manager</h2>
            <p class="text-gray-500 mb-8 text-center max-w-md">Store, organize, and access your files from anywhere. PaperVault keeps your documents safe and at your fingertips.</p>
            <div class="flex gap-4">
                @auth
                    <a href="{{ route('drive') }}" class="px-6 py-2 rounded-lg bg-indigo-600 text-white font-semibold shadow hover:bg-indigo-700 transition">Go to My Vault</a>
                @else
                    <a href="{{ route('login') }}" class="px-6 py-2 rounded-lg bg-indigo-600 text-white font-semibold shadow hover:bg-indigo-700 transition">Login</a>
                    <a href="{{ route('register') }}" class="px-6 py-2 rounded-lg bg-white border border-indigo-600 text-indigo-700 font-semibold shadow hover:bg-indigo-50 transition">Register</a>
                @endauth
            </div>
            <div class="mt-10 text-xs text-gray-400">&copy; {{ date('Y') }} PaperVault. All rights reserved.</div>
        </div>
    </body>
</html>
