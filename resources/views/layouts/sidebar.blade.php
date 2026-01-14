<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Game Collection and Expense Management System</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
<div class="flex">
    <aside class="w-64 bg-white border-r min-h-screen p-4 flex flex-col">
        <!-- Sidebar Header -->
        <div class="mb-6">
            <a href="{{ route('games.index') }}" class="block">
                <div class="text-xl font-bold text-blue-600 leading-tight">
                    Game Collection
                </div>
                <div class="text-sm text-gray-600">
                    & Expense Management System
                </div>
            </a>
            <div class="mt-1 h-1 w-12 bg-blue-600 rounded-full"></div>
        </div>

        <!-- Navigation -->
        <nav class="space-y-2 flex-1">
            <a href="{{ route('games.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('games.*') && !request()->routeIs('games.trash') ? 'bg-blue-100 font-semibold' : '' }}">Games</a>
            <a href="{{ route('platforms.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('platforms.*') ? 'bg-blue-100 font-semibold' : '' }}">Platforms</a>
            <a href="{{ route('games.trash') }}" class="block px-3 py-2 rounded {{ request()->routeIs('games.trash') ? 'bg-blue-100 font-semibold' : '' }}">Trash</a>
        </nav>

        <!-- Footer / User Info -->
        <div class="mt-auto pt-6 border-t mt-6">
            <div class="text-sm font-medium">{{ auth()->user()->name ?? 'User' }}</div>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button class="text-sm text-red-600 hover:underline">Logout</button>
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
