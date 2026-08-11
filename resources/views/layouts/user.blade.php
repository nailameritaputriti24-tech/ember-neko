<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="EMBER - Early Monitoring for Burning Environment Response">
    <title>@yield('title', 'EMBER')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
    @php($currentLanguage = request('lang') === 'en' ? 'en' : 'id')
    <div class="bg-slate-950 px-4 py-2 text-center text-[11px] font-semibold uppercase tracking-[0.15em] text-slate-300">
        Early Monitoring for Burning Environment Response
    </div>
    <header class="border-b border-slate-200/80 bg-white shadow-sm">
        <nav class="mx-auto flex min-h-18 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8" aria-label="Navigasi utama">
            <a href="{{ route('user.dashboard', ['lang' => $currentLanguage]) }}" class="flex shrink-0 items-center gap-3">
                <span class="flex size-10 items-center justify-center rounded-xl bg-red-600 text-white shadow-lg shadow-red-600/20">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="size-5" aria-hidden="true">
                        <path d="M12 9v4m0 4h.01M10.3 3.7 2.2 17.3A2 2 0 0 0 3.9 20h16.2a2 2 0 0 0 1.7-2.7L13.7 3.7a2 2 0 0 0-3.4 0Z"/>
                    </svg>
                </span>
                <span>
                    <span class="block text-base font-bold leading-none text-slate-950">EMBER</span>
                    <span class="mt-1 block text-[9px] font-semibold uppercase tracking-[0.08em] text-slate-500">Early Monitoring for Burning Environment Response</span>
                </span>
            </a>

            <div class="hidden items-stretch self-stretch text-xs font-semibold text-slate-600 lg:flex xl:text-sm">
                <a href="{{ route('user.dashboard', ['lang' => $currentLanguage]) }}" class="flex items-center border-b-2 px-3 transition hover:border-red-500 hover:text-red-600 {{ request()->routeIs('user.dashboard') ? 'border-red-500 text-red-600' : 'border-transparent' }}">{{ $currentLanguage === 'en' ? 'Home' : 'Beranda' }}</a>
                <a href="{{ route('user.map', ['lang' => $currentLanguage]) }}" class="flex items-center border-b-2 px-3 transition hover:border-red-500 hover:text-red-600 {{ request()->routeIs('user.map') ? 'border-red-500 text-red-600' : 'border-transparent' }}">{{ $currentLanguage === 'en' ? 'Map' : 'Peta' }}</a>
                <a href="{{ route('user.statistics', ['lang' => $currentLanguage]) }}" class="flex items-center border-b-2 px-3 transition hover:border-red-500 hover:text-red-600 {{ request()->routeIs('user.statistics') ? 'border-red-500 text-red-600' : 'border-transparent' }}">{{ $currentLanguage === 'en' ? 'Statistics' : 'Statistik' }}</a>
                <a href="{{ route('user.about', ['lang' => $currentLanguage]) }}" class="flex items-center border-b-2 px-3 transition hover:border-red-500 hover:text-red-600 {{ request()->routeIs('user.about') ? 'border-red-500 text-red-600' : 'border-transparent' }}">About</a>
                <a href="{{ route('user.methodology', ['lang' => $currentLanguage]) }}" class="flex items-center border-b-2 px-3 transition hover:border-red-500 hover:text-red-600 {{ request()->routeIs('user.methodology') ? 'border-red-500 text-red-600' : 'border-transparent' }}">Methodology</a>
                <a href="{{ route('user.team', ['lang' => $currentLanguage]) }}" class="flex items-center border-b-2 px-3 transition hover:border-red-500 hover:text-red-600 {{ request()->routeIs('user.team') ? 'border-red-500 text-red-600' : 'border-transparent' }}">Team</a>
            </div>

            <div class="flex items-center gap-2">
                <div class="hidden overflow-hidden rounded-lg border border-slate-300 text-xs font-bold sm:flex">
                    <a href="{{ request()->url() }}?lang=id" class="px-2.5 py-2 {{ $currentLanguage === 'id' ? 'bg-slate-900 text-white' : 'text-slate-500 hover:bg-slate-50' }}">ID</a>
                    <a href="{{ request()->url() }}?lang=en" class="px-2.5 py-2 {{ $currentLanguage === 'en' ? 'bg-slate-900 text-white' : 'text-slate-500 hover:bg-slate-50' }}">EN</a>
                </div>
                <form method="GET" action="{{ route('user.search') }}" class="hidden items-center overflow-hidden rounded-lg border border-slate-300 bg-white xl:flex">
                    <input type="hidden" name="lang" value="{{ $currentLanguage }}">
                    <label for="header-search" class="sr-only">{{ $currentLanguage === 'en' ? 'Search' : 'Cari' }}</label>
                    <input id="header-search" name="q" value="{{ request('q') }}" placeholder="{{ $currentLanguage === 'en' ? 'Search...' : 'Cari...' }}" class="w-32 border-0 px-3 py-2 text-xs outline-none placeholder:text-slate-400">
                    <button type="submit" class="flex size-9 items-center justify-center bg-slate-900 text-white" aria-label="{{ $currentLanguage === 'en' ? 'Search' : 'Cari' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="size-4" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                    </button>
                </form>

                <details class="group relative lg:hidden">
                    <summary class="flex size-10 cursor-pointer list-none items-center justify-center rounded-lg border border-slate-300 text-slate-700 marker:content-none">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="size-5" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
                    </summary>
                    <div class="absolute right-0 top-12 w-64 overflow-hidden rounded-xl border border-slate-200 bg-white p-2 shadow-2xl">
                        <a href="{{ route('user.dashboard', ['lang' => $currentLanguage]) }}" class="block rounded-lg px-4 py-3 text-sm font-semibold hover:bg-slate-50">{{ $currentLanguage === 'en' ? 'Home' : 'Beranda' }}</a>
                        <a href="{{ route('user.map', ['lang' => $currentLanguage]) }}" class="block rounded-lg px-4 py-3 text-sm font-semibold hover:bg-slate-50">{{ $currentLanguage === 'en' ? 'Interactive Map' : 'Peta Interaktif' }}</a>
                        <a href="{{ route('user.statistics', ['lang' => $currentLanguage]) }}" class="block rounded-lg px-4 py-3 text-sm font-semibold hover:bg-slate-50">{{ $currentLanguage === 'en' ? 'Statistics' : 'Statistik' }}</a>
                        <a href="{{ route('user.about', ['lang' => $currentLanguage]) }}" class="block rounded-lg px-4 py-3 text-sm font-semibold hover:bg-slate-50">About</a>
                        <a href="{{ route('user.methodology', ['lang' => $currentLanguage]) }}" class="block rounded-lg px-4 py-3 text-sm font-semibold hover:bg-slate-50">Methodology</a>
                        <a href="{{ route('user.team', ['lang' => $currentLanguage]) }}" class="block rounded-lg px-4 py-3 text-sm font-semibold hover:bg-slate-50">Team</a>
                        <div class="mt-2 grid grid-cols-2 border-t border-slate-200 pt-2 text-center text-xs font-bold">
                            <a href="{{ request()->url() }}?lang=id" class="px-3 py-2 {{ $currentLanguage === 'id' ? 'bg-slate-900 text-white' : '' }}">ID</a>
                            <a href="{{ request()->url() }}?lang=en" class="px-3 py-2 {{ $currentLanguage === 'en' ? 'bg-slate-900 text-white' : '' }}">EN</a>
                        </div>
                        <form method="GET" action="{{ route('user.search') }}" class="mt-2 flex border-t border-slate-200 pt-2">
                            <input type="hidden" name="lang" value="{{ $currentLanguage }}">
                            <input name="q" value="{{ request('q') }}" placeholder="{{ $currentLanguage === 'en' ? 'Search...' : 'Cari...' }}" class="min-w-0 flex-1 border border-slate-300 px-3 py-2 text-sm outline-none">
                            <button type="submit" class="bg-slate-900 px-3 text-xs font-bold text-white">{{ $currentLanguage === 'en' ? 'Search' : 'Cari' }}</button>
                        </form>
                    </div>
                </details>
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    @if (! View::hasSection('hideFooter'))
    <footer class="border-t border-slate-200 bg-white">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 py-10 sm:px-6 md:grid-cols-[1fr_auto] lg:px-8">
            <div>
                <p class="font-bold text-slate-950">EMBER</p>
                <p class="mt-2 max-w-md text-sm leading-6 text-slate-500">Early Monitoring for Burning Environment Response.</p>
                <p class="mt-4 text-xs text-slate-400">&copy; {{ date('Y') }} EMBER.</p>
            </div>
            <div class="grid grid-cols-2 gap-x-8 gap-y-3 text-sm font-medium text-slate-600 sm:grid-cols-3">
                <a href="{{ route('user.dashboard', ['lang' => $currentLanguage]) }}" class="hover:text-red-600">{{ $currentLanguage === 'en' ? 'Home' : 'Beranda' }}</a>
                <a href="{{ route('user.about', ['lang' => $currentLanguage]) }}" class="hover:text-red-600">About</a>
                <a href="{{ route('user.methodology', ['lang' => $currentLanguage]) }}" class="hover:text-red-600">Methodology</a>
                <a href="{{ route('user.team', ['lang' => $currentLanguage]) }}" class="hover:text-red-600">Team</a>
                <a href="{{ route('user.map', ['lang' => $currentLanguage]) }}" class="hover:text-red-600">{{ $currentLanguage === 'en' ? 'Map' : 'Peta' }}</a>
                <a href="{{ route('user.statistics', ['lang' => $currentLanguage]) }}" class="hover:text-red-600">{{ $currentLanguage === 'en' ? 'Statistics' : 'Statistik' }}</a>
                <a href="{{ route('user.search', ['lang' => $currentLanguage]) }}" class="hover:text-red-600">{{ $currentLanguage === 'en' ? 'Search' : 'Pencarian' }}</a>
            </div>
        </div>
    </footer>

    <button id="back-to-top" type="button" aria-label="{{ $currentLanguage === 'en' ? 'Back to top' : 'Kembali ke atas' }}" title="{{ $currentLanguage === 'en' ? 'Back to top' : 'Kembali ke atas' }}" class="pointer-events-none fixed bottom-5 right-5 z-50 flex size-12 translate-y-3 items-center justify-center rounded-full bg-red-600 text-white opacity-0 shadow-xl shadow-red-600/25 transition duration-200 hover:bg-red-500 focus:outline-none focus:ring-4 focus:ring-red-200 sm:bottom-7 sm:right-7">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" class="size-5" aria-hidden="true">
            <path d="m6 15 6-6 6 6"/>
        </svg>
    </button>
    @endif

    @livewireScripts
</body>
</html>
