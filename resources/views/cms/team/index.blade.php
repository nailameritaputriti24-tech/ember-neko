@extends('layouts.admin')

@section('title', 'Team - EMBER CMS')

@section('content')
    <div class="mx-auto max-w-7xl">
        <div class="mb-6">
            <p class="text-sm font-semibold uppercase tracking-wider text-red-600">Konten situs</p>
            <h1 class="mt-1 text-3xl font-bold tracking-tight text-slate-950">Team</h1>
            <p class="mt-2 text-sm text-slate-600">Tambahkan dan kelola anggota tim EMBER.</p>
        </div>

        <div class="grid gap-6 xl:grid-cols-[520px_1fr]">
            <form method="POST" action="{{ route('cms.team.store') }}" class="h-fit rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                @csrf
                <h2 class="text-lg font-bold text-slate-900">Tambah anggota</h2>
                <div class="mt-5 space-y-4">
                    <div class="grid gap-px bg-slate-200 sm:grid-cols-2">
                        @foreach (['id' => 'ID', 'en' => 'EN'] as $locale => $code)
                            <div class="space-y-4 bg-white p-4">
                                <p class="border-b border-slate-200 pb-3 text-xs font-bold uppercase tracking-wider text-red-600">Konten {{ $code }}</p>
                                <div>
                                    <label for="name_{{ $locale }}" class="block text-sm font-semibold text-slate-700">Nama {{ $code }}</label>
                                    <input id="name_{{ $locale }}" name="name_{{ $locale }}" value="{{ old('name_'.$locale) }}" required class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-red-500 focus:outline-none focus:ring-4 focus:ring-red-100">
                                </div>
                                <div>
                                    <label for="position_{{ $locale }}" class="block text-sm font-semibold text-slate-700">{{ $locale === 'id' ? 'Jabatan' : 'Position' }} {{ $code }}</label>
                                    <input id="position_{{ $locale }}" name="position_{{ $locale }}" value="{{ old('position_'.$locale) }}" required class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-red-500 focus:outline-none focus:ring-4 focus:ring-red-100">
                                </div>
                                <div>
                                    <label for="bio_{{ $locale }}" class="block text-sm font-semibold text-slate-700">Bio {{ $code }}</label>
                                    <textarea id="bio_{{ $locale }}" name="bio_{{ $locale }}" rows="3" class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-red-500 focus:outline-none focus:ring-4 focus:ring-red-100">{{ old('bio_'.$locale) }}</textarea>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div>
                        <label for="photo_url" class="block text-sm font-semibold text-slate-700">URL foto</label>
                        <input id="photo_url" name="photo_url" type="url" value="{{ old('photo_url') }}" placeholder="https://domain.com/images/nama.jpg" aria-describedby="photo-url-reference" class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-red-500 focus:outline-none focus:ring-4 focus:ring-red-100">
                        <div id="photo-url-reference" class="mt-2 border-l-2 border-slate-300 pl-3 text-xs leading-5 text-slate-500">
                            <p class="font-semibold text-slate-600">Referensi URL foto</p>
                            <p>Gunakan URL publik yang langsung menuju file JPG, PNG, atau WebP.</p>
                            <p class="font-mono text-[11px] text-slate-400">https://domain.com/images/nama.jpg</p>
                        </div>
                    </div>
                    <div>
                        <label for="sort_order" class="block text-sm font-semibold text-slate-700">Urutan</label>
                        <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', 0) }}" class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-red-500 focus:outline-none focus:ring-4 focus:ring-red-100">
                    </div>
                    <label class="flex items-center gap-2 text-sm text-slate-700">
                        <input type="checkbox" name="is_active" value="1" checked class="rounded border-slate-300 text-red-600 focus:ring-red-500"> Aktif
                    </label>
                    @if ($errors->any())
                        <p class="text-sm text-red-600">Periksa kembali data anggota tim.</p>
                    @endif
                </div>
                <button type="submit" class="mt-5 w-full rounded-xl bg-red-600 px-4 py-3 text-sm font-bold text-white transition hover:bg-red-500">Tambah anggota</button>
            </form>

            <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
                <div class="border-b border-slate-200 px-6 py-5">
                    <h2 class="font-bold text-slate-900">Daftar anggota</h2>
                    <p class="mt-1 text-sm text-slate-500">{{ $members->count() }} anggota tersimpan</p>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse ($members as $member)
                        <div class="flex items-center gap-4 p-5">
                            @if ($member->photo_url)
                                <img src="{{ $member->photo_url }}" alt="Foto {{ $member->name }}" class="size-12 rounded-xl object-cover">
                            @else
                                <span class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-slate-100 font-bold text-slate-500">{{ strtoupper(substr($member->name, 0, 1)) }}</span>
                            @endif
                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <p class="font-bold text-slate-900">{{ $member->name_id ?: $member->name }}</p>
                                    <span class="rounded-full px-2 py-0.5 text-xs font-semibold {{ $member->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">{{ $member->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                </div>
                                <p class="text-sm text-red-600">ID: {{ $member->position_id ?: $member->position }}</p>
                                <p class="text-sm text-slate-500">EN: {{ $member->position_en ?: '-' }}</p>
                                @if ($member->bio_id)<p class="mt-1 line-clamp-2 text-sm text-slate-500">{{ $member->bio_id }}</p>@endif
                            </div>
                            <form method="POST" action="{{ route('cms.team.destroy', $member->id) }}" onsubmit="return confirm('Hapus anggota ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-lg border border-red-200 px-3 py-2 text-xs font-semibold text-red-600 transition hover:bg-red-50">Hapus</button>
                            </form>
                        </div>
                    @empty
                        <div class="px-6 py-16 text-center text-sm text-slate-500">Belum ada anggota tim.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
