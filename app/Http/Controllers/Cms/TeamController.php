<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function index(): View
    {
        return view('cms.team.index', [
            'members' => DB::table('team_members')->orderBy('sort_order')->orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'photo' => ['required', 'string', 'max:255'],
            'nama' => ['required', 'string', 'max:255'],
            'npm' => ['required', 'string', 'max:100'],
        ]);

        DB::table('team_members')->insert([
            'photo' => $validated['photo'],
            'nama' => $validated['nama'],
            'npm' => $validated['npm'],
            'name' => $validated['nama'],
            'position' => $validated['npm'],
            'name_id' => $validated['nama'],
            'name_en' => $validated['nama'],
            'position_id' => $validated['npm'],
            'position_en' => $validated['npm'],
            'sort_order' => (int) DB::table('team_members')->max('sort_order') + 1,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Anggota tim berhasil ditambahkan.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $member = DB::table('team_members')->where('id', $id)->firstOrFail();

        DB::table('team_members')->where('id', $id)->delete();

        return back()->with('success', 'Anggota tim berhasil dihapus.');
    }
}
