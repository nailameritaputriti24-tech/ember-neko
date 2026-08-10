<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MethodologyController extends Controller
{
    public function edit(): View
    {
        return view('cms.methodology.edit', [
            'methodology' => DB::table('methodology_pages')->first(),
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

        $methodology = DB::table('methodology_pages')->first();
        $values = [
            'content_id' => $validated['content_id'] ?? null,
            'content_en' => $validated['content_en'] ?? null,
            'updated_at' => now(),
        ];

        foreach (['image_id', 'image_en'] as $field) {
            if ($request->hasFile($field)) {
                if ($methodology?->{$field}) {
                    Storage::disk('public')->delete($methodology->{$field});
                }

                $values[$field] = $request->file($field)->store('methodology', 'public');
            }
        }

        if ($methodology) {
            DB::table('methodology_pages')->where('id', $methodology->id)->update($values);
        } else {
            DB::table('methodology_pages')->insert([
                ...$values,
                'title_id' => 'Metodologi EMBER',
                'title_en' => 'EMBER Methodology',
                'created_at' => now(),
            ]);
        }

        return back()->with('success', 'Konten Methodology ID dan EN berhasil disimpan.');
    }
}
