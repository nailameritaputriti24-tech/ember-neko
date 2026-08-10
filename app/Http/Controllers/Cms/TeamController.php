<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'nama' => ['required', 'string', 'max:255'],
            'npm' => ['required', 'string', 'max:100'],
        ]);

        $photoPath = $request->file('photo')->store('team', 'public');

        DB::table('team_members')->insert([
            'photo' => $photoPath,
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

        if ($member->photo) {
            Storage::disk('public')->delete($member->photo);
        }

        DB::table('team_members')->where('id', $id)->delete();

        return back()->with('success', 'Anggota tim berhasil dihapus.');
    }
}
