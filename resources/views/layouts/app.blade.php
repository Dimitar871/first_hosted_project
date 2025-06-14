<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Task App') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col">

    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-xl font-semibold text-gray-900">Task App</a>

            <nav class="flex gap-4 items-center">
                @auth
                    <a href="{{ route('tasks.index') }}" class="text-gray-700 hover:text-blue-600">Tasks</a>
                    <a href="{{ route('tasks.create') }}" class="text-gray-700 hover:text-blue-600">Create</a>
                    <a href="{{ route('profile.edit') }}" class="text-gray-700 hover:text-blue-600">Profile</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-700">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Login</a>
                    <a href="{{ route('register') }}" class="text-gray-700 hover:text-blue-600">Register</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="flex-grow py-8 px-4">
        <div class="max-w-4xl mx-auto">
            @if (session('success'))
                <div class="mb-4 p-3 rounded bg-green-100 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="text-center text-gray-500 py-4">
        &copy; {{ date('Y') }} Task App. All rights reserved.
    </footer>
</body>
</html>
