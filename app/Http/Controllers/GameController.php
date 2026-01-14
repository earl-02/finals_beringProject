<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Platform;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::with('platform')->latest()->paginate(20);
        $platforms = Platform::orderBy('name')->get();

        $totalGames = Game::count();
        $totalPlatforms = Platform::count();
        $totalSpent = Game::sum('price');

        return view('games.index', compact(
            'games',
            'platforms',
            'totalGames',
            'totalPlatforms',
            'totalSpent'
        ));
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
