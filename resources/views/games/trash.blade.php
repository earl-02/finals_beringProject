@extends('layouts.sidebar')

@section('content')
<div class="bg-white p-4 rounded shadow">
	<h3 class="font-semibold mb-3">Trash — Deleted Games</h3>

	<table class="w-full text-left">
		<thead>
			<tr class="border-b">
				<th class="py-2">Title</th>
				<th>Year</th>
				<th>Platform</th>
				<th>Deleted At</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@forelse($trashed as $game)
				<tr class="border-b">
					<td class="py-2 flex items-center gap-3">
						@if($game->photo)
							<img src="{{ asset('storage/' . $game->photo) }}" alt="" class="w-10 h-10 rounded-full object-cover">
						@else
							@php
								$parts = preg_split('/\s+/', $game->title);
								$initials = strtoupper(collect($parts)->filter()->map(fn($w)=>substr($w,0,1))->take(2)->join(''));
							@endphp
							<div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center font-semibold text-gray-700">{{ $initials }}</div>
						@endif
						<div>{{ $game->title }}</div>
					</td>
					<td>{{ $game->release_year }}</td>
					<td>{{ $game->platform->name ?? 'N/A' }}</td>
					<td>{{ $game->deleted_at?->format('Y-m-d H:i') }}</td>
					<td class="text-right">
						<form method="POST" action="{{ route('games.restore', $game->id) }}" style="display:inline">
							@csrf
							<button class="mr-2 px-3 py-1 bg-green-600 text-white rounded" onclick="return confirm('Restore this game?')">Restore</button>
						</form>

						<form method="POST" action="{{ route('games.forceDelete', $game->id) }}" style="display:inline">
							@csrf
							@method('DELETE')
							<button class="px-3 py-1 bg-red-600 text-white rounded" onclick="return confirm('Permanently delete this game? This cannot be undone.')">Delete Permanently</button>
						</form>
					</td>
				</tr>
			@empty
				<tr><td colspan="5" class="py-4 text-center text-gray-500">No trashed games found.</td></tr>
			@endforelse
		</tbody>
	</table>

	<div class="mt-4">
		{{ $trashed->links() }}
	</div>
</div>
@endsection
