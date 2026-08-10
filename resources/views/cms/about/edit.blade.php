@extends('layouts.admin')

@section('title', 'About - EMBER CMS')

@section('content')
    <div class="mx-auto max-w-7xl">
        <div class="mb-6">
            <p class="text-sm font-semibold uppercase tracking-wider text-red-600">Konten dua bahasa</p>
            <h1 class="mt-1 text-3xl font-bold tracking-tight text-slate-950">About</h1>
            <p class="mt-2 text-sm text-slate-600">Isi konten bahasa Indonesia dan bahasa Inggris secara berdampingan.</p>
        </div>

        <form method="POST" action="{{ route('cms.about.update') }}" class="bg-white p-6 shadow-sm ring-1 ring-slate-200 sm:p-8">
            @csrf
            @method('PUT')

            <div class="grid gap-px bg-slate-200 lg:grid-cols-2">
                @foreach (['id' => ['Indonesia', 'ID'], 'en' => ['English', 'EN']] as $locale => [$languageName, $code])
                    <section class="bg-white p-5 sm:p-6">
                        <div class="mb-5 flex items-center justify-between border-b border-slate-200 pb-4">
                            <h2 class="font-bold text-slate-900">{{ $languageName }}</h2>
                            <span class="bg-slate-900 px-2.5 py-1 text-xs font-bold text-white">{{ $code }}</span>
                        </div>

                        <div class="space-y-5">
                            <div>
                                <label for="title_{{ $locale }}" class="block text-sm font-semibold text-slate-700">Judul {{ $code }}</label>
                                <input id="title_{{ $locale }}" name="title_{{ $locale }}" value="{{ old('title_'.$locale, $about->{'title_'.$locale} ?? ($locale === 'id' ? 'Tentang EMBER' : 'About EMBER')) }}" required class="mt-2 w-full border border-slate-300 px-4 py-3 text-sm focus:border-red-500 focus:outline-none focus:ring-4 focus:ring-red-100">
                                @error('title_'.$locale)<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="description_{{ $locale }}" class="block text-sm font-semibold text-slate-700">Deskripsi {{ $code }}</label>
                                <textarea id="description_{{ $locale }}" name="description_{{ $locale }}" rows="5" class="mt-2 w-full border border-slate-300 px-4 py-3 text-sm focus:border-red-500 focus:outline-none focus:ring-4 focus:ring-red-100">{{ old('description_'.$locale, $about->{'description_'.$locale} ?? null) }}</textarea>
                            </div>
                            <div>
                                <label for="vision_{{ $locale }}" class="block text-sm font-semibold text-slate-700">{{ $locale === 'id' ? 'Visi' : 'Vision' }}</label>
                                <textarea id="vision_{{ $locale }}" name="vision_{{ $locale }}" rows="4" class="mt-2 w-full border border-slate-300 px-4 py-3 text-sm focus:border-red-500 focus:outline-none focus:ring-4 focus:ring-red-100">{{ old('vision_'.$locale, $about->{'vision_'.$locale} ?? null) }}</textarea>
                            </div>
                            <div>
                                <label for="mission_{{ $locale }}" class="block text-sm font-semibold text-slate-700">{{ $locale === 'id' ? 'Misi' : 'Mission' }}</label>
                                <textarea id="mission_{{ $locale }}" name="mission_{{ $locale }}" rows="4" class="mt-2 w-full border border-slate-300 px-4 py-3 text-sm focus:border-red-500 focus:outline-none focus:ring-4 focus:ring-red-100">{{ old('mission_'.$locale, $about->{'mission_'.$locale} ?? null) }}</textarea>
                            </div>
                        </div>
                    </section>
                @endforeach
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="border border-red-600 bg-red-600 px-5 py-3 text-sm font-bold text-white transition hover:bg-red-500">Simpan About ID & EN</button>
            </div>
        </form>
    </div>
@endsection
