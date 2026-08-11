@extends('layouts.user')

@section('title', ($language === 'en' ? 'About' : 'Tentang') . ' - EMBER')

@section('content')
    @php
        $content = $about?->{'content_'.$language};
        $image = $about?->{'image_'.$language};
    @endphp

    <section class="bg-slate-950 px-4 py-16 text-white sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <p class="text-sm font-bold uppercase tracking-[0.2em] text-red-400">EMBER</p>
            <h1 class="mt-4 max-w-3xl text-4xl font-bold tracking-tight sm:text-5xl">{{  $language === 'en' ? 'About EMBER' : 'Tentang EMBER' }}</h1>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-4 py-14 sm:px-6 lg:px-8">
        @if ($about)
            <div class="space-y-8">
                @if ($image)
                    <img src="{{ asset('storage/'.$image) }}" alt="{{ $language === 'en' ? 'About EMBER' : 'Tentang EMBER' }}" class="mx-auto aspect-video w-full max-w-3xl bg-slate-100 object-cover">
                @else
                    <div class="mx-auto flex aspect-video w-full max-w-3xl items-center justify-center bg-slate-100 text-sm font-semibold text-slate-400">{{ $language === 'en' ? 'Image is not available yet' : 'Gambar belum tersedia' }}</div>
                @endif
                <div class="rich-content max-w-4xl text-lg leading-8 text-slate-700">{!! $content ?: e($language === 'en' ? 'About content is not available yet.' : 'Konten About belum tersedia.') !!}</div>
            </div>
        @else
            <p class="border border-slate-200 bg-white p-8 text-slate-500">{{ $language === 'en' ? 'About content is not available yet.' : 'Konten About belum tersedia.' }}</p>
        @endif
    </section>
@endsection
