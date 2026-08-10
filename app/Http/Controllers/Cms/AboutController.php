<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function edit(): View
    {
        return view('cms.about.edit', [
            'about' => DB::table('about_pages')->first(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title_id' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'description_id' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'vision_id' => ['nullable', 'string'],
            'vision_en' => ['nullable', 'string'],
            'mission_id' => ['nullable', 'string'],
            'mission_en' => ['nullable', 'string'],
        ]);

        $legacyValues = [
            'title' => $validated['title_id'],
            'description' => $validated['description_id'] ?? null,
            'vision' => $validated['vision_id'] ?? null,
            'mission' => $validated['mission_id'] ?? null,
        ];

        $about = DB::table('about_pages')->first();

        if ($about) {
            DB::table('about_pages')->where('id', $about->id)->update([
                ...$validated,
                ...$legacyValues,
                'updated_at' => now(),
            ]);
        } else {
            DB::table('about_pages')->insert([
                ...$validated,
                ...$legacyValues,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return back()->with('success', 'Konten About ID dan EN berhasil disimpan.');
    }
}
