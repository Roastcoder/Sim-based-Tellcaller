<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;

class TeamController extends Controller
{
    public function index()
    {
        return view('teams.index');
    }

    public function create()
    {
        return view('teams.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('teams.index');
    }

    public function show(Team $team)
    {
        return view('teams.show', compact('team'));
    }

    public function edit(Team $team)
    {
        return view('teams.edit', compact('team'));
    }

    public function update(Request $request, Team $team)
    {
        return redirect()->route('teams.index');
    }

    public function destroy(Team $team)
    {
        return redirect()->route('teams.index');
    }
}