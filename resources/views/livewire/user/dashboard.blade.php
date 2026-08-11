<div>
    @php
        $t = [
            'id' => [
                'headline_before' => 'Pantau titik rawan kebakaran dalam', 'headline_highlight' => 'satu peta.',
                'intro' => 'Lihat persebaran lokasi, tingkat peringatan, dan informasi terbaru secara cepat dan mudah.',
                'cta' => 'Lihat peta EMBER', 'total_alerts' => 'Total Peringatan', 'with_confidence' => 'Data dengan confidence',
                'total_locations' => 'Total Lokasi', 'points_on_map' => 'Titik pada peta', 'high_alerts' => 'Peringatan Tinggi',
                'critical' => 'Status kritis', 'last_updated' => 'Terakhir Diperbarui', 'not_available' => 'Belum ada', 'latest_data' => 'Data terbaru',
                'interactive_map' => 'Peta interaktif', 'map_title' => 'Persebaran lokasi EMBER', 'high' => 'Tinggi', 'medium' => 'Sedang',
                'low' => 'Rendah', 'unrated' => 'Belum dinilai', 'explore' => 'Jelajahi EMBER', 'explore_title' => 'Informasi yang transparan dan mudah dipahami',
                'about_desc' => 'Kenali tujuan, visi, dan misi di balik sistem pemantauan EMBER.',
                'method_desc' => 'Pelajari sumber data, proses pengolahan, dan klasifikasi confidence.',
                'team_desc' => 'Kenali tim yang mengelola data dan informasi pada portal EMBER.', 'read_more' => 'Selengkapnya',
                'about_title' => 'Tentang', 'method_title' => 'Metodologi', 'team_title' => 'Tim',
            ],
            'en' => [
                'headline_before' => 'Monitor fire-prone locations on', 'headline_highlight' => 'one map.',
                'intro' => 'Explore location distribution, alert levels, and the latest information quickly and clearly.',
                'cta' => 'View EMBER map', 'total_alerts' => 'Total Alerts', 'with_confidence' => 'Data with confidence',
                'total_locations' => 'Total Locations', 'points_on_map' => 'Points on the map', 'high_alerts' => 'High Alerts',
                'critical' => 'Critical status', 'last_updated' => 'Last Updated', 'not_available' => 'Not available', 'latest_data' => 'Latest data',
                'interactive_map' => 'Interactive map', 'map_title' => 'EMBER location distribution', 'high' => 'High', 'medium' => 'Medium',
                'low' => 'Low', 'unrated' => 'Unrated', 'explore' => 'Explore EMBER', 'explore_title' => 'Transparent and accessible information',
                'about_desc' => 'Discover the purpose, vision, and mission behind the EMBER monitoring system.',
                'method_desc' => 'Learn about data sources, processing methods, and confidence classification.',
                'team_desc' => 'Meet the team managing data and information across the EMBER portal.', 'read_more' => 'Learn more',
                'about_title' => 'About', 'method_title' => 'Methodology', 'team_title' => 'Team',
            ],
        ][$language];
    @endphp
    <section class="relative overflow-hidden bg-slate-950">
        <div class="absolute inset-0 opacity-30" aria-hidden="true">
            <div class="absolute -left-24 top-10 size-72 rounded-full bg-red-600 blur-3xl"></div>
            <div class="absolute right-0 top-0 size-96 rounded-full bg-orange-500/50 blur-3xl"></div>
        </div>

        <div class="relative mx-auto grid max-w-7xl gap-10 px-4 py-16 sm:px-6 lg:grid-cols-[1.1fr_.9fr] lg:items-center lg:px-8 lg:py-22">
            <div>
                <span class="inline-flex items-center gap-2 rounded-full border border-red-400/30 bg-red-500/10 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-red-300">
                    <span class="size-2 rounded-full bg-red-400"></span>
                    Early Monitoring for Burning Environment Response
                </span>
                <h1 class="mt-6 max-w-3xl text-4xl font-bold tracking-tight text-white sm:text-5xl lg:text-6xl">
                    {{ $t['headline_before'] }} <span class="text-red-400">{{ $t['headline_highlight'] }}</span>
                </h1>
                <p class="mt-5 max-w-2xl text-base leading-8 text-slate-300 sm:text-lg">
                    {{ $t['intro'] }}
                </p>
                <a href="{{ route('user.map', ['lang' => $language]) }}" class="mt-8 inline-flex items-center gap-2 rounded-xl bg-red-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-red-600/25 transition hover:bg-red-500">
                    {{ $t['cta'] }}
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="size-4" aria-hidden="true">
                        <path d="m9 18 6-6-6-6"/>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-2 gap-3 sm:gap-4">
                <div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                    <p class="text-sm text-slate-400">{{ $t['total_alerts'] }}</p>
                    <p class="mt-3 text-3xl font-bold text-white">{{ $totalWarnings }}</p>
                    <p class="mt-2 text-xs text-slate-500">{{ $t['with_confidence'] }}</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                    <p class="text-sm text-slate-400">{{ $t['total_locations'] }}</p>
                    <p class="mt-3 text-3xl font-bold text-white">{{ $totalLocations }}</p>
                    <p class="mt-2 text-xs text-slate-500">{{ $t['points_on_map'] }}</p>
                </div>
                <div class="rounded-2xl border border-red-400/20 bg-red-500/10 p-5 backdrop-blur">
                    <p class="text-sm text-red-200">{{ $t['high_alerts'] }}</p>
                    <p class="mt-3 text-3xl font-bold text-white">{{ $highWarnings }}</p>
                    <p class="mt-2 text-xs text-red-300/60">{{ $t['critical'] }}</p>
                </div>
                <div class="rounded-2xl border border-emerald-400/20 bg-emerald-500/10 p-5 backdrop-blur">
                    <p class="text-sm text-emerald-200">{{ $t['last_updated'] }}</p>
                    <p class="mt-3 text-lg font-bold text-white">{{ $t['not_available'] }}</p>
                    <p class="mt-2 text-xs text-emerald-300/60">{{ $t['latest_data'] }}</p>
                </div>
            </div>
        </div>
    </section>

    <section id="informasi" class="border-t border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            <div class="mb-8 max-w-2xl">
                <p class="text-sm font-bold uppercase tracking-wider text-red-600">{{ $t['explore'] }}</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-950">{{ $t['explore_title'] }}</h2>
            </div>
            <div class="grid gap-px overflow-hidden rounded-2xl bg-slate-200 ring-1 ring-slate-200 md:grid-cols-3">
                @foreach ([
                    ['01', $t['about_title'], $t['about_desc'], route('user.about', ['lang' => $language])],
                    ['02', $t['method_title'], $t['method_desc'], route('user.methodology', ['lang' => $language])],
                    ['03', $t['team_title'], $t['team_desc'], route('user.team', ['lang' => $language])],
                ] as [$number, $title, $description, $url])
                    <a href="{{ $url }}" class="group bg-white p-7 transition hover:bg-slate-50">
                        <p class="text-sm font-bold text-red-600">{{ $number }}</p>
                        <h3 class="mt-5 text-xl font-bold text-slate-950">{{ $title }}</h3>
                        <p class="mt-3 min-h-18 text-sm leading-6 text-slate-600">{{ $description }}</p>
                        <span class="mt-6 inline-flex items-center gap-2 text-sm font-bold text-slate-900 group-hover:text-red-600">{{ $t['read_more'] }} <span aria-hidden="true">&rarr;</span></span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
</div>
