<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTeamMemberRequest;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    public function index()
    {
        return view('admin.team.index', ['members' => TeamMember::orderBy('sort_order')->paginate(15)]);
    }

    public function create()
    {
        return view('admin.team.create');
    }

    public function store(StoreTeamMemberRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('team', 'public');
        }
        TeamMember::create($data);
        return redirect()->route('admin.team.index')->with('success', 'Team member added.');
    }

    public function edit(TeamMember $team)
    {
        return view('admin.team.edit', ['member' => $team]);
    }

    public function update(StoreTeamMemberRequest $request, TeamMember $team)
    {
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            if ($team->photo) Storage::disk('public')->delete($team->photo);
            $data['photo'] = $request->file('photo')->store('team', 'public');
        }
        $team->update($data);
        return redirect()->route('admin.team.index')->with('success', 'Team member updated.');
    }

    public function destroy(TeamMember $team)
    {
        if ($team->photo) Storage::disk('public')->delete($team->photo);
        $team->delete();
        return redirect()->route('admin.team.index')->with('success', 'Team member removed.');
    }
}
