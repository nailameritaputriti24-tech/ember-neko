@extends('layouts.user')

@section('title', ($language === 'en' ? 'About' : 'Tentang') . ' - EMBER')

@section('content')
    @php
        $title = $about?->{'title_'.$language};
        $description = $about?->{'description_'.$language};
        $vision = $about?->{'vision_'.$language};
        $mission = $about?->{'mission_'.$language};
    @endphp

    <section class="bg-slate-950 px-4 py-16 text-white sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="flex items-end justify-between gap-6">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.2em] text-red-400">EMBER</p>
                    <h1 class="mt-4 max-w-3xl text-4xl font-bold tracking-tight sm:text-5xl">{{ $title ?: ($language === 'en' ? 'About EMBER' : 'Tentang EMBER') }}</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        @if ($about)
            <p class="max-w-4xl whitespace-pre-line text-lg leading-8 text-slate-700">{{ $description }}</p>
            <div class="mt-10 grid gap-px bg-slate-200 md:grid-cols-2">
                <article class="bg-white p-7">
                    <p class="text-xs font-bold uppercase tracking-wider text-red-600">{{ $language === 'en' ? 'Vision' : 'Visi' }}</p>
                    <p class="mt-4 whitespace-pre-line leading-7 text-slate-700">{{ $vision ?: '-' }}</p>
                </article>
                <article class="bg-white p-7">
                    <p class="text-xs font-bold uppercase tracking-wider text-red-600">{{ $language === 'en' ? 'Mission' : 'Misi' }}</p>
                    <p class="mt-4 whitespace-pre-line leading-7 text-slate-700">{{ $mission ?: '-' }}</p>
                </article>
            </div>
        @else
            <p class="border border-slate-200 bg-white p-8 text-slate-500">{{ $language === 'en' ? 'About content is not available yet.' : 'Konten About belum tersedia.' }}</p>
        @endif
    </section>
@endsection
