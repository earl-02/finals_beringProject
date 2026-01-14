<?php

namespace App\Http\Controllers;

use App\Models\Platform;
use Illuminate\Http\Request;

class PlatformController extends Controller
{
    public function index()
    {
        $platforms = Platform::withCount('games')
            ->orderBy('name')
            ->paginate(20);

        return view('platforms.index', compact('platforms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:platforms,name',
            'manufacturer' => 'nullable|string',
        ]);

        Platform::create($data);

        return redirect()->back()->with('success', 'Platform added.');
    }

    public function update(Request $request, Platform $platform)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:platforms,name,' . $platform->id,
            'manufacturer' => 'nullable|string',
        ]);

        $platform->update($data);

        return redirect()->back()->with('success', 'Platform updated.');
    }

    public function destroy(Platform $platform)
    {
        $platform->delete();

        return redirect()->back()->with('success', 'Platform deleted.');
    }
}
