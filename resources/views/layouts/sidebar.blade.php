<!doctype html>
<html lang="en">
<head>
    <!-- ...existing head (meta, tailwind, scripts) ... -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
<div class="flex">
    <aside class="w-64 bg-white border-r min-h-screen p-4">
        <div class="mb-6">
            <a href="{{ route('games.index') }}" class="text-lg font-bold">{{ config('app.name') }}</a>
        </div>

        <nav class="space-y-2">
            <a href="{{ route('games.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('games.*') ? 'bg-blue-100' : '' }}">Games</a>
            <a href="{{ route('platforms.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('platforms.*') ? 'bg-blue-100' : '' }}">Platforms</a>
        </nav>

        <div class="mt-auto pt-6 border-t mt-6">
            <div class="text-sm">{{ auth()->user()->name ?? 'User' }}</div>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button class="text-sm text-red-600">Logout</button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-6">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>
</div>
</body>
</html>
