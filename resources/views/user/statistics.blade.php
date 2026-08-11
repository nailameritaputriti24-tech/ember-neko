@extends('layouts.user')

@section('title', ($language === 'en' ? 'Statistics' : 'Statistik') . ' - EMBER')

@section('content')
    @php
        $statuses = [
            'high' => ['label' => $language === 'en' ? 'High' : 'Tinggi', 'color' => 'bg-red-500', 'text' => 'text-red-600'],
            'medium' => ['label' => $language === 'en' ? 'Medium' : 'Sedang', 'color' => 'bg-amber-400', 'text' => 'text-amber-600'],
            'low' => ['label' => $language === 'en' ? 'Low' : 'Rendah', 'color' => 'bg-emerald-500', 'text' => 'text-emerald-600'],
            'unrated' => ['label' => $language === 'en' ? 'Unrated' : 'Belum dinilai', 'color' => 'bg-slate-500', 'text' => 'text-slate-600'],
        ];
    @endphp

    <section class="bg-slate-950 px-4 py-16 text-white sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <p class="text-sm font-bold uppercase tracking-[0.2em] text-red-400">EMBER DATA</p>
            <h1 class="mt-4 text-4xl font-bold tracking-tight sm:text-5xl">{{ $language === 'en' ? 'Annual Statistics' : 'Statistik Tahunan' }}</h1>
            <p class="mt-4 max-w-2xl leading-7 text-slate-300">{{ $language === 'en' ? 'Yearly distribution of EMBER locations by confidence status.' : 'Distribusi titik lokasi EMBER setiap tahun berdasarkan status confidence.' }}</p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid gap-px bg-slate-200 sm:grid-cols-2 lg:grid-cols-5">
            <article class="bg-white p-5">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">{{ $language === 'en' ? 'All locations' : 'Semua lokasi' }}</p>
                <p class="mt-3 text-4xl font-bold text-slate-950">{{ number_format($summary['total']) }}</p>
            </article>
            @foreach ($statuses as $key => $status)
                <article class="bg-white p-5">
                    <div class="flex items-center gap-2"><span class="size-2.5 rounded-full {{ $status['color'] }}"></span><p class="text-xs font-bold uppercase tracking-wider text-slate-400">{{ $status['label'] }}</p></div>
                    <p class="mt-3 text-4xl font-bold {{ $status['text'] }}">{{ number_format($summary[$key]) }}</p>
                </article>
            @endforeach
        </div>

        @if ($yearlyStatistics->isNotEmpty())
            <div class="mt-10 space-y-5">
                @foreach ($yearlyStatistics as $statistic)
                    <article class="border border-slate-200 bg-white p-5 sm:p-6">
                        <div class="flex items-end justify-between gap-5">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-red-600">{{ $language === 'en' ? 'Year' : 'Tahun' }}</p>
                                <h2 class="mt-1 text-3xl font-bold text-slate-950">{{ $statistic['year'] }}</h2>
                            </div>
                            <p class="text-sm font-semibold text-slate-500"><span class="text-2xl font-bold text-slate-950">{{ $statistic['total'] }}</span> {{ $language === 'en' ? 'locations' : 'lokasi' }}</p>
                        </div>

                        <div class="mt-5 flex h-4 overflow-hidden bg-slate-100" aria-label="{{ $language === 'en' ? 'Status distribution' : 'Distribusi status' }}">
                            @foreach ($statuses as $key => $status)
                                @if ($statistic['percentages'][$key] > 0)
                                    <span class="{{ $status['color'] }}" style="width: {{ $statistic['percentages'][$key] }}%" title="{{ $status['label'] }}: {{ $statistic['counts'][$key] }}"></span>
                                @endif
                            @endforeach
                        </div>

                        <div class="mt-5 grid grid-cols-2 gap-3 lg:grid-cols-4">
                            @foreach ($statuses as $key => $status)
                                <div class="border-l-2 border-slate-200 pl-3">
                                    <p class="text-xs font-semibold text-slate-500">{{ $status['label'] }}</p>
                                    <p class="mt-1 font-bold text-slate-950">{{ $statistic['counts'][$key] }} <span class="text-xs font-medium text-slate-400">({{ number_format($statistic['percentages'][$key], 1) }}%)</span></p>
                                </div>
                            @endforeach
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-10 overflow-x-auto border border-slate-200 bg-white">
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                    <thead class="bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="px-5 py-4">{{ $language === 'en' ? 'Year' : 'Tahun' }}</th>
                            <th class="px-5 py-4">{{ $language === 'en' ? 'Total' : 'Jumlah' }}</th>
                            @foreach ($statuses as $status)<th class="px-5 py-4">{{ $status['label'] }}</th>@endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($yearlyStatistics as $statistic)
                            <tr>
                                <td class="px-5 py-4 font-bold text-slate-950">{{ $statistic['year'] }}</td>
                                <td class="px-5 py-4 font-bold text-slate-950">{{ $statistic['total'] }}</td>
                                @foreach ($statuses as $key => $status)<td class="px-5 py-4 text-slate-600">{{ $statistic['counts'][$key] }}</td>@endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="mt-10 border border-slate-200 bg-white p-10 text-center text-slate-500">{{ $language === 'en' ? 'No dated location data is available yet.' : 'Belum ada data lokasi yang memiliki tanggal.' }}</div>
        @endif
    </section>
@endsection
