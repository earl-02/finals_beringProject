@extends('layouts.sidebar')

@section('content')
<div class="grid md:grid-cols-2 gap-6">
    <div class="bg-white p-4 rounded shadow">
        <h3 class="font-semibold mb-3">Add Platform</h3>
        <form method="POST" action="{{ route('platforms.store') }}">
            @csrf
            <div class="mb-2">
                <label class="block text-sm">Name</label>
                <input name="name" class="w-full border p-2 rounded" />
                @error('name') <div class="text-red-600 text-sm">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm">Manufacturer</label>
                <input name="manufacturer" class="w-full border p-2 rounded" />
            </div>
            <button class="bg-blue-600 text-white px-3 py-2 rounded">Add Platform</button>
        </form>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <h3 class="font-semibold mb-3">Platforms</h3>
        <table class="w-full text-left">
            <thead>
                <tr class="border-b">
                    <th class="py-2">Name</th>
                    <th>Manufacturer</th>
                    <th>Games</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($platforms as $p)
                    <tr class="border-b">
                        <td class="py-2">{{ $p->name }}</td>
                        <td>{{ $p->manufacturer ?? '-' }}</td>
                        <td>{{ $p->games_count }} {{ $p->games_count == 1 ? 'game' : 'games' }}</td>
                        <td class="text-right">
                            <button class="mr-2 text-blue-600" onclick="openPlatformEdit({{ $p->id }}, '{{ addslashes($p->name) }}', '{{ addslashes($p->manufacturer) }}')">Edit</button>
                            <form method="POST" action="{{ route('platforms.destroy', $p) }}" style="display:inline" onsubmit="return confirm('Delete this platform?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $platforms->links() }}
        </div>
    </div>
</div>

<!-- Platform Edit Modal -->
<div id="platformEditModal" class="fixed inset-0 z-50 hidden flex items-center justify-center backdrop-blur-sm bg-white/10 transition-opacity duration-300">
    <div class="bg-white p-4 rounded w-full max-w-md shadow-lg border border-black">
        <h3 class="font-semibold mb-2">Edit Platform</h3>
        <form id="platformEditForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-2">
                <label class="block text-sm">Name</label>
                <input id="p_name" name="name" class="w-full border p-2 rounded" />
            </div>
            <div class="mb-4">
                <label class="block text-sm">Manufacturer</label>
                <input id="p_manufacturer" name="manufacturer" class="w-full border p-2 rounded" />
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" class="px-3 py-2" onclick="closePlatformEdit()">Cancel</button>
                <button class="bg-blue-600 text-white px-3 py-2 rounded">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
function openPlatformEdit(id,name,manufacturer){
    const modal = document.getElementById('platformEditModal');
    modal.classList.remove('hidden');
    document.getElementById('p_name').value = name;
    document.getElementById('p_manufacturer').value = manufacturer || '';
    document.getElementById('platformEditForm').action = '/platforms/' + id;
}
function closePlatformEdit(){
    const modal = document.getElementById('platformEditModal');
    modal.classList.add('hidden');
}
</script>
@endsection
