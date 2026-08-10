@extends('layouts.user')

@section('title', 'Methodology - EMBER')

@section('content')
    @php
        $title = $methodology?->{'title_'.$language};
        $sections = [
            $language === 'en' ? 'Introduction' : 'Pendahuluan' => $methodology?->{'introduction_'.$language},
            $language === 'en' ? 'Data Sources' : 'Sumber Data' => $methodology?->{'data_source_'.$language},
            $language === 'en' ? 'Processing Method' : 'Proses Pengolahan' => $methodology?->{'process_'.$language},
            $language === 'en' ? 'Confidence Classification' : 'Klasifikasi Confidence' => $methodology?->{'classification_'.$language},
        ];
    @endphp

    <section class="bg-slate-950 px-4 py-16 text-white sm:px-6 lg:px-8">
        <div class="mx-auto flex max-w-7xl items-end justify-between gap-6">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-red-400">{{ $language === 'en' ? 'How it works' : 'Cara kerja' }}</p>
                <h1 class="mt-4 max-w-3xl text-4xl font-bold tracking-tight sm:text-5xl">{{ $title ?: ($language === 'en' ? 'EMBER Methodology' : 'Metodologi EMBER') }}</h1>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-4 py-14 sm:px-6 lg:px-8">
        @if ($methodology)
            <div class="border-l border-slate-300">
                @foreach ($sections as $heading => $content)
                    <article class="relative border-b border-slate-200 py-8 pl-8">
                        <span class="absolute -left-2 top-10 size-4 border-4 border-slate-50 bg-red-600"></span>
                        <p class="text-xs font-bold uppercase tracking-wider text-red-600">0{{ $loop->iteration }}</p>
                        <h2 class="mt-2 text-2xl font-bold text-slate-950">{{ $heading }}</h2>
                        <p class="mt-4 whitespace-pre-line leading-8 text-slate-700">{{ $content ?: '-' }}</p>
                    </article>
                @endforeach
            </div>
        @else
            <p class="border border-slate-200 bg-white p-8 text-slate-500">{{ $language === 'en' ? 'Methodology content is not available yet.' : 'Konten metodologi belum tersedia.' }}</p>
        @endif
    </section>
@endsection
