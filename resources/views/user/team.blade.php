@extends('layouts.user')

@section('title', 'Team - EMBER')

@section('content')
    <section class="bg-slate-950 px-4 py-16 text-white sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <p class="text-sm font-bold uppercase tracking-[0.2em] text-red-400">EMBER</p>
            <h1 class="mt-4 text-4xl font-bold tracking-tight sm:text-5xl">{{ $language === 'en' ? 'Our Team' : 'Tim Kami' }}</h1>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="grid gap-px bg-slate-200 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($members as $member)
                @php($name = $member->nama ?: $member->name)
                <article class="bg-white">
                    @if ($member->photo)
                        <img src="{{ asset('storage/'.$member->photo) }}" alt="{{ $name }}" class="aspect-[4/3] w-full bg-slate-100 object-cover">
                    @else
                        <div class="flex aspect-[4/3] items-center justify-center bg-slate-100 text-5xl font-bold text-slate-300">{{ strtoupper(substr($name, 0, 1)) }}</div>
                    @endif
                    <div class="p-6">
                        <h2 class="text-lg font-bold text-slate-950">{{ $name }}</h2>
                        <p class="mt-2 text-sm font-semibold text-red-600">NPM: {{ $member->npm ?: '-' }}</p>
                    </div>
                </article>
            @empty
                <p class="bg-white p-8 text-slate-500 sm:col-span-2 lg:col-span-3">{{ $language === 'en' ? 'Team information is not available yet.' : 'Informasi tim belum tersedia.' }}</p>
            @endforelse
        </div>
    </section>
@endsection
