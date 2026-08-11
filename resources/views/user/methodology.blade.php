@extends('layouts.user')

@section('title', ($language === 'en' ? 'Methodology' : 'Metodologi') . ' - EMBER')

@section('content')
    @php
        $content = $methodology?->{'content_'.$language};
    @endphp

    <section class="bg-slate-950 px-4 py-16 text-white sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <p class="text-sm font-bold uppercase tracking-[0.2em] text-red-400">{{ $language === 'en' ? 'How it works' : 'Cara kerja' }}</p>
            <h1 class="mt-4 max-w-3xl text-4xl font-bold tracking-tight sm:text-5xl">{{ $language === 'en' ? 'EMBER Methodology' : 'Metodologi EMBER' }}</h1>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-4 py-14 sm:px-6 lg:px-8">
        @if ($methodology)
            <div class="rich-content text-lg leading-8 text-slate-700">{!! $content ?: e($language === 'en' ? 'Methodology content is not available yet.' : 'Konten Methodology belum tersedia.') !!}</div>
        @else
            <p class="border border-slate-200 bg-white p-8 text-slate-500">{{ $language === 'en' ? 'Methodology content is not available yet.' : 'Konten Methodology belum tersedia.' }}</p>
        @endif
    </section>
@endsection
