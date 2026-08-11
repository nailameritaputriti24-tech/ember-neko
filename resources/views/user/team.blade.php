@extends('layouts.user')

@section('title', ($language === 'en' ? 'Team' : 'Tim') . ' - EMBER')

@section('content')
    <section class="bg-slate-950 px-4 py-16 text-white sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <p class="text-sm font-bold uppercase tracking-[0.2em] text-red-400">EMBER</p>
            <h1 class="mt-4 text-4xl font-bold tracking-tight sm:text-5xl">{{ $language === 'en' ? 'Our Team' : 'Tim Kami' }}</h1>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="divide-y divide-slate-200 border-y border-slate-200 bg-white">
            @forelse ($members as $member)
                @php
                    $name = $member->nama ?: $member->name;
                    $description = $member->{'bio_'.$language} ?: $member->bio;
                @endphp
                <article class="grid gap-5 py-7 md:grid-cols-[5rem_minmax(0,1fr)] md:items-start">
                    @if ($member->photo)
                        <img src="{{ asset('storage/'.$member->photo) }}" alt="{{ $name }}" class="mx-auto size-20 rounded-full bg-slate-100 object-cover md:mx-0">
                    @else
                        <div class="mx-auto flex size-20 items-center justify-center rounded-full bg-slate-100 text-2xl font-bold text-slate-300 md:mx-0">{{ strtoupper(substr($name, 0, 1)) }}</div>
                    @endif
                    <div class="min-w-0 py-1">
                        <h2 class="text-2xl font-bold text-slate-950">{{ $name }}</h2>
                        <p class="mt-2 text-sm font-semibold text-red-600">NPM: {{ $member->npm ?: '-' }}</p>

                        @if ($description)
                            <p class="mt-4 whitespace-pre-line text-sm leading-7 text-slate-600">{{ $description }}</p>
                        @endif

                        @if ($member->github_url)
                            <a href="{{ $member->github_url }}" target="_blank" rel="noopener noreferrer" class="mt-5 inline-flex items-center gap-2 border border-slate-300 px-4 py-2 text-sm font-bold text-slate-700 transition hover:border-red-300 hover:bg-red-50 hover:text-red-700">
                                {{ $language === 'en' ? 'GitHub Repository' : 'Repository GitHub' }} <span aria-hidden="true">&nearr;</span>
                            </a>
                        @endif
                    </div>
                </article>
            @empty
                <p class="p-8 text-slate-500">{{ $language === 'en' ? 'Team information is not available yet.' : 'Informasi tim belum tersedia.' }}</p>
            @endforelse
        </div>
    </section>
@endsection
