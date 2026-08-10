<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
            'image_id' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'image_en' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'content_id' => ['nullable', 'string'],
            'content_en' => ['nullable', 'string'],
        ]);

        $about = DB::table('about_pages')->first();
        $values = [
            'content_id' => $validated['content_id'] ?? null,
            'content_en' => $validated['content_en'] ?? null,
            'updated_at' => now(),
        ];

        foreach (['image_id', 'image_en'] as $field) {
            if ($request->hasFile($field)) {
                if ($about?->{$field}) {
                    Storage::disk('public')->delete($about->{$field});
                }

                $values[$field] = $request->file($field)->store('about', 'public');
            }
        }

        if ($about) {
            DB::table('about_pages')->where('id', $about->id)->update($values);
        } else {
            DB::table('about_pages')->insert([
                ...$values,
                'title' => 'Tentang EMBER',
                'title_id' => 'Tentang EMBER',
                'title_en' => 'About EMBER',
                'created_at' => now(),
            ]);
        }

        return back()->with('success', 'Konten About ID dan EN berhasil disimpan.');
    }
}
