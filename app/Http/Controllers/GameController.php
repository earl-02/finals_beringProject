<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Platform;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $platform_id = $request->query('platform_id');

        $games = Game::with('platform')
            ->when($search, function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            })
            ->when($platform_id, function ($q) use ($platform_id) {
                $q->where('platform_id', $platform_id);
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $platforms = Platform::orderBy('name')->get();
        $totalGames = Game::count();
        $totalPlatforms = Platform::count();
        $totalSpent = Game::sum('price');

        return view('games.index', compact('games', 'platforms', 'totalGames', 'totalPlatforms', 'totalSpent', 'search', 'platform_id'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'release_year' => 'required|integer',
            'price' => 'required|numeric',
            'platform_id' => 'nullable|exists:platforms,id',
        ]);

        Game::create($data);

        return redirect()->back()->with('success', 'Game added successfully.');
    }

    public function update(Request $request, Game $game)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'release_year' => 'required|integer',
            'price' => 'required|numeric',
            'platform_id' => 'nullable|exists:platforms,id',
        ]);

        $game->update($data);

        return redirect()->back()->with('success', 'Game updated successfully.');
    }

    public function destroy(Game $game)
    {
        $game->delete();

        return redirect()->back()->with('success', 'Game deleted.');
    }
}
