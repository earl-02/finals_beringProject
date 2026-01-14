@extends('layouts.sidebar')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="p-4 bg-white rounded shadow">
        <div class="text-sm text-gray-500">Total Games</div>
        <div class="text-2xl font-bold">{{ $totalGames }}</div>
    </div>
    <div class="p-4 bg-white rounded shadow">
        <div class="text-sm text-gray-500">Total Platforms</div>
        <div class="text-2xl font-bold">{{ $totalPlatforms }}</div>
    </div>
    <div class="p-4 bg-white rounded shadow">
        <div class="text-sm text-gray-500">Total Amount Spent</div>
        <div class="text-2xl font-bold">₱{{ number_format($totalSpent,2) }}</div>
    </div>
</div>

<div class="grid md:grid-cols-3 gap-6">
    <div class="md:col-span-1 bg-white p-4 rounded shadow">
        <h3 class="font-semibold mb-3">Add New Game</h3>
        <form method="POST" action="{{ route('games.store') }}">
            @csrf
            <div class="mb-2">
                <label class="block text-sm">Title</label>
                <input name="title" value="{{ old('title') }}" class="w-full border p-2 rounded" />
                @error('title') <div class="text-red-600 text-sm">{{ $message }}</div>@enderror
            </div>
            <div class="mb-2">
                <label class="block text-sm">Release Year</label>
                <input name="release_year" value="{{ old('release_year') }}" class="w-full border p-2 rounded" />
                @error('release_year') <div class="text-red-600 text-sm">{{ $message }}</div>@enderror
            </div>
            <div class="mb-2">
                <label class="block text-sm">Money spent</label>
                <input name="price" value="{{ old('price') }}" class="w-full border p-2 rounded" />
                @error('price') <div class="text-red-600 text-sm">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm">Platform</label>
                <select name="platform_id" class="w-full border p-2 rounded">
                    <option value="">None</option>
                    @foreach($platforms as $p)
                        <option value="{{ $p->id }}" @selected(old('platform_id')==$p->id)>{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>
            <button class="bg-blue-600 text-white px-3 py-2 rounded">Add Game</button>
        </form>
    </div>

    <div class="md:col-span-2 bg-white p-4 rounded shadow">
        <h3 class="font-semibold mb-3">Games</h3>

        <!-- Search & Filter -->
        <form method="GET" action="{{ route('games.index') }}" class="mb-4 flex flex-wrap gap-2 items-center">
            <input
                name="search"
                value="{{ $search ?? request('search') }}"
                placeholder="Search title..."
                class="border p-2 rounded flex-1 min-w-[160px]"
            />

            <select name="platform_id" class="border p-2 rounded">
                <option value="">All Platforms</option>
                @foreach($platforms as $p)
                    <option value="{{ $p->id }}" @selected((string)($platform_id ?? request('platform_id')) === (string)$p->id)>{{ $p->name }}</option>
                @endforeach
            </select>

            <button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded">Filter</button>
            <a href="{{ route('games.index') }}" class="px-3 py-2 bg-gray-200 rounded">Clear Filters</a>
        </form>

        <table class="w-full text-left">
            <thead>
                <tr class="border-b">
                    <th class="py-2">Title</th>
                    <th>Year</th>
                    <th>Platform</th>
                    <th>Money spent</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($games as $game)
                    <tr class="border-b">
                        <td class="py-2">{{ $game->title }}</td>
                        <td>{{ $game->release_year }}</td>
                        <td>{{ $game->platform->name ?? 'N/A' }}</td>
                        <td>₱{{ number_format($game->price,2) }}</td>
                        <td class="text-right">
                            <button class="mr-2 text-blue-600"
                                onclick="openEdit({{ $game->id }}, '{{ addslashes($game->title) }}', {{ $game->release_year }}, '{{ $game->price }}', {{ $game->platform_id ?? 'null' }})">
                                Edit
                            </button>
                            <form method="POST" action="{{ route('games.destroy', $game) }}" style="display:inline" onsubmit="return confirm('Delete this game?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $games->links() }}
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 z-50 hidden flex items-center justify-center backdrop-blur-sm bg-white/10 transition-opacity duration-300">
    <div class="bg-white p-4 rounded w-full max-w-lg shadow-lg border border-black">
        <h3 class="font-semibold mb-2">Edit Game</h3>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-2">
                <label class="block text-sm">Title</label>
                <input id="e_title" name="title" class="w-full border p-2 rounded" />
            </div>
            <div class="mb-2">
                <label class="block text-sm">Release Year</label>
                <input id="e_release_year" name="release_year" class="w-full border p-2 rounded" />
            </div>
            <div class="mb-2">
                <label class="block text-sm">Money spent</label>
                <input id="e_price" name="price" class="w-full border p-2 rounded" />
            </div>
            <div class="mb-4">
                <label class="block text-sm">Platform</label>
                <select id="e_platform_id" name="platform_id" class="w-full border p-2 rounded">
                    <option value="">None</option>
                    @foreach($platforms as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" class="px-3 py-2" onclick="closeEdit()">Cancel</button>
                <button class="bg-blue-600 text-white px-3 py-2 rounded">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEdit(id,title,year,price,platform_id){
    const modal = document.getElementById('editModal');
    modal.classList.remove('hidden');
    document.getElementById('e_title').value = title;
    document.getElementById('e_release_year').value = year;
    document.getElementById('e_price').value = price;
    document.getElementById('e_platform_id').value = platform_id ?? '';
    document.getElementById('editForm').action = '/games/' + id;
}
function closeEdit(){
    const modal = document.getElementById('editModal');
    modal.classList.add('hidden');
}
</script>
@endsection
