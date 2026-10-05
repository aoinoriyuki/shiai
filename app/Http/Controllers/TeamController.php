<?php

namespace App\Http\Controllers;

use App\Models\team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $team = auth()->user()->team;
        return view('team.index', compact('team'));
    }

    /**
     * Search for other teams.
     */
    public function search(Request $request)
    {
        $query = team::query();

        // チーム名での検索
        if ($request->filled('team_name')) {
            $query->where('team_name', 'like', '%' . $request->team_name . '%');
        }

        // 種目での検索
        if ($request->filled('event')) {
            $query->where('event', 'like', '%' . $request->event . '%');
        }

        // ログインユーザー自身のチームは除外する（持っていれば）
        if (auth()->user()->team) {
            $query->where('id', '!=', auth()->user()->team->id);
        }

        $teams = $query->paginate(10);

        return view('team.search', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('team.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'team_name' => 'required|max:255',
            'event' => 'required|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'contact' => 'required|max:255',
        ]);

        $request->user()->team()->create($validated);
        return redirect()->route('team.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(team $team)
    {
        // チーム詳細画面用
        return view('team.show', compact('team'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $team = auth()->user()->team;
        return view('team.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, team $team)
    {
        $validated = $request->validate([
            'team_name' => 'required|max:255',
            'event' => 'required|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'contact' => 'required|max:255',
        ]);

        $request->user()->team()->update($validated);
        return redirect()->route('team.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(team $team)
    {
        //
    }
}
