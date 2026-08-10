@extends('layouts.admin')

@section('title', 'Methodology - EMBER CMS')

@section('content')
    <div class="mx-auto max-w-7xl">
        <div class="mb-6">
            <p class="text-sm font-semibold uppercase tracking-wider text-red-600">Konten dua bahasa</p>
            <h1 class="mt-1 text-3xl font-bold tracking-tight text-slate-950">Methodology</h1>
            <p class="mt-2 text-sm text-slate-600">Kelola gambar dan konten Methodology untuk bahasa Indonesia dan Inggris.</p>
        </div>

        <form method="POST" action="{{ route('cms.methodology.update') }}" enctype="multipart/form-data" class="bg-white p-6 shadow-sm ring-1 ring-slate-200 sm:p-8">
            @csrf
            @method('PUT')

            <div class="grid gap-px bg-slate-200 lg:grid-cols-2">
                @foreach (['id' => ['Indonesia', 'ID'], 'en' => ['English', 'EN']] as $locale => [$languageName, $code])
                    @php($imageField = 'image_'.$locale)
                    @php($contentField = 'content_'.$locale)
                    <section class="bg-white p-5 sm:p-6">
                        <div class="mb-5 flex items-center justify-between border-b border-slate-200 pb-4">
                            <h2 class="font-bold text-slate-900">{{ $languageName }}</h2>
                            <span class="bg-slate-900 px-2.5 py-1 text-xs font-bold text-white">{{ $code }}</span>
                        </div>

                        @if ($methodology?->{$imageField})
                            <img src="{{ asset('storage/'.$methodology->{$imageField}) }}" alt="Methodology {{ $code }}" class="mb-4 aspect-video w-full bg-slate-100 object-cover">
                        @endif

                        <div>
                            <label for="{{ $imageField }}" class="block text-sm font-semibold text-slate-700">Image {{ $code }}</label>
                            <input id="{{ $imageField }}" name="{{ $imageField }}" type="file" accept="image/jpeg,image/png,image/webp" class="mt-2 block w-full border border-slate-300 bg-white p-3 text-sm text-slate-600 file:mr-4 file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-xs file:font-bold file:text-white">
                            <p class="mt-2 text-xs text-slate-500">JPG, PNG, atau WebP. Maksimal 5 MB.</p>
                            @error($imageField)<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="mt-5">
                            <label for="{{ $contentField }}" class="block text-sm font-semibold text-slate-700">Content {{ $code }}</label>
                            <textarea id="{{ $contentField }}" name="{{ $contentField }}" rows="12" class="mt-2 w-full border border-slate-300 px-4 py-3 text-sm leading-7 focus:border-red-500 focus:outline-none focus:ring-4 focus:ring-red-100">{{ old($contentField, $methodology?->{$contentField}) }}</textarea>
                            @error($contentField)<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </section>
                @endforeach
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="border border-red-600 bg-red-600 px-5 py-3 text-sm font-bold text-white transition hover:bg-red-500">Simpan Methodology</button>
            </div>
        </form>
    </div>
@endsection
