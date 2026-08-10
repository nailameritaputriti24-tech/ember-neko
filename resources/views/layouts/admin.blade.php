<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'EMBER CMS')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        .cms-shell *, .cms-login * { border-radius: 0 !important; }
    </style>
</head>
<body class="min-h-screen bg-slate-100 text-slate-900 antialiased">
    @auth
        <div class="cms-shell min-h-screen">
            <header class="border-b border-slate-800 bg-slate-950 text-white">
                <div class="mx-auto flex max-w-7xl flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex h-18 items-center justify-between px-4 sm:px-6 lg:px-8">
                        <a href="{{ route('cms.locations.index') }}" class="flex items-center gap-3">
                            <span class="flex size-9 items-center justify-center bg-red-600 font-bold">E</span>
                            <span>
                                <span class="block text-sm font-bold">EMBER CMS</span>
                                <span class="block text-[10px] uppercase tracking-widest text-slate-400">Content Management</span>
                            </span>
                        </a>
                        <a href="{{ route('user.dashboard') }}" class="ml-8 text-xs font-medium text-slate-400 transition hover:text-white lg:hidden">Lihat situs</a>
                    </div>

                    <div class="flex min-w-0 items-center justify-between border-t border-slate-800 lg:border-t-0">
                        <nav class="flex min-w-0 overflow-x-auto px-2 sm:px-4" aria-label="Menu CMS">
                            <a href="{{ route('cms.about.edit') }}" class="shrink-0 border-b-2 px-4 py-4 text-sm font-semibold transition {{ request()->routeIs('cms.about.*') ? 'border-red-500 bg-white/10 text-white' : 'border-transparent text-slate-300 hover:border-slate-500 hover:text-white' }}">About</a>
                            <a href="{{ route('cms.methodology.edit') }}" class="shrink-0 border-b-2 px-4 py-4 text-sm font-semibold transition {{ request()->routeIs('cms.methodology.*') ? 'border-red-500 bg-white/10 text-white' : 'border-transparent text-slate-300 hover:border-slate-500 hover:text-white' }}">Methodology</a>
                            <a href="{{ route('cms.team.index') }}" class="shrink-0 border-b-2 px-4 py-4 text-sm font-semibold transition {{ request()->routeIs('cms.team.*') ? 'border-red-500 bg-white/10 text-white' : 'border-transparent text-slate-300 hover:border-slate-500 hover:text-white' }}">Team</a>
                            <a href="{{ route('cms.references.index') }}" class="shrink-0 border-b-2 px-4 py-4 text-sm font-semibold transition {{ request()->routeIs('cms.references.*') ? 'border-red-500 bg-white/10 text-white' : 'border-transparent text-slate-300 hover:border-slate-500 hover:text-white' }}">Reference</a>
                            <a href="{{ route('cms.locations.index') }}" class="shrink-0 border-b-2 px-4 py-4 text-sm font-semibold transition {{ request()->routeIs('cms.locations.*') ? 'border-red-500 bg-white/10 text-white' : 'border-transparent text-slate-300 hover:border-slate-500 hover:text-white' }}">Titik Lokasi</a>
                        </nav>

                        <div class="hidden items-center gap-4 border-l border-slate-800 px-5 lg:flex">
                            <div class="max-w-44">
                                <p class="truncate text-xs font-semibold">{{ auth()->user()->name }}</p>
                                <p class="truncate text-[11px] text-slate-500">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ route('user.dashboard') }}" class="text-xs font-medium text-slate-400 transition hover:text-white">Lihat situs</a>
                            <form method="POST" action="{{ route('cms.logout') }}">
                                @csrf
                                <button type="submit" class="border border-slate-700 px-3 py-2 text-xs font-semibold text-slate-300 transition hover:border-red-500 hover:text-white">Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="min-w-0 p-4 sm:p-6 lg:p-8">
                @if (session('success'))
                    <div class="mx-auto mb-5 max-w-7xl rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    @else
        <main class="cms-login">@yield('content')</main>
    @endauth

    @livewireScripts
</body>
</html>
