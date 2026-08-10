<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            'title_id' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'introduction_id' => ['nullable', 'string'],
            'introduction_en' => ['nullable', 'string'],
            'data_source_id' => ['nullable', 'string'],
            'data_source_en' => ['nullable', 'string'],
            'process_id' => ['nullable', 'string'],
            'process_en' => ['nullable', 'string'],
            'classification_id' => ['nullable', 'string'],
            'classification_en' => ['nullable', 'string'],
        ]);

        $methodology = DB::table('methodology_pages')->first();

        if ($methodology) {
            DB::table('methodology_pages')->where('id', $methodology->id)->update([
                ...$validated,
                'updated_at' => now(),
            ]);
        } else {
            DB::table('methodology_pages')->insert([
                ...$validated,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return back()->with('success', 'Konten Methodology ID dan EN berhasil disimpan.');
    }
}
