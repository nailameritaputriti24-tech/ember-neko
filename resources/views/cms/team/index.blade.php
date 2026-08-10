@extends('layouts.admin')

@section('title', 'Team - EMBER CMS')

@section('content')
    <div class="mx-auto max-w-7xl">
        <div class="mb-6">
            <p class="text-sm font-semibold uppercase tracking-wider text-red-600">Konten situs</p>
            <h1 class="mt-1 text-3xl font-bold tracking-tight text-slate-950">Team</h1>
            <p class="mt-2 text-sm text-slate-600">Kelola foto, nama, dan NPM anggota tim EMBER.</p>
        </div>

        <div class="grid gap-6 xl:grid-cols-[420px_1fr]">
            <form method="POST" action="{{ route('cms.team.store') }}" enctype="multipart/form-data" class="h-fit bg-white p-6 shadow-sm ring-1 ring-slate-200">
                @csrf
                <h2 class="text-lg font-bold text-slate-900">Tambah anggota</h2>
                <div class="mt-5 space-y-5">
                    <div>
                        <label for="photo" class="block text-sm font-semibold text-slate-700">Photo</label>
                        <input id="photo" name="photo" type="file" accept="image/jpeg,image/png,image/webp" required class="mt-2 block w-full border border-slate-300 bg-white p-3 text-sm text-slate-600 file:mr-4 file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-xs file:font-bold file:text-white">
                        @error('photo')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="nama" class="block text-sm font-semibold text-slate-700">Nama</label>
                        <input id="nama" name="nama" value="{{ old('nama') }}" required class="mt-2 w-full border border-slate-300 px-4 py-3 text-sm focus:border-red-500 focus:outline-none focus:ring-4 focus:ring-red-100">
                        @error('nama')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="npm" class="block text-sm font-semibold text-slate-700">NPM</label>
                        <input id="npm" name="npm" value="{{ old('npm') }}" required class="mt-2 w-full border border-slate-300 px-4 py-3 text-sm focus:border-red-500 focus:outline-none focus:ring-4 focus:ring-red-100">
                        @error('npm')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>
                <button type="submit" class="mt-6 w-full border border-red-600 bg-red-600 px-4 py-3 text-sm font-bold text-white transition hover:bg-red-500">Tambah Anggota</button>
            </form>

            <div class="bg-white shadow-sm ring-1 ring-slate-200">
                <div class="border-b border-slate-200 px-6 py-5">
                    <h2 class="font-bold text-slate-900">Daftar anggota</h2>
                    <p class="mt-1 text-sm text-slate-500">{{ $members->count() }} anggota tersimpan</p>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse ($members as $member)
                        <div class="flex items-center gap-4 p-5">
                            @if ($member->photo)
                                <img src="{{ asset('storage/'.$member->photo) }}" alt="Foto {{ $member->nama }}" class="size-16 shrink-0 object-cover">
                            @else
                                <span class="flex size-16 shrink-0 items-center justify-center bg-slate-100 font-bold text-slate-500">{{ strtoupper(substr($member->nama ?: $member->name, 0, 1)) }}</span>
                            @endif
                            <div class="min-w-0 flex-1">
                                <p class="font-bold text-slate-900">{{ $member->nama ?: $member->name }}</p>
                                <p class="mt-1 text-sm font-semibold text-red-600">NPM: {{ $member->npm ?: '-' }}</p>
                            </div>
                            <form method="POST" action="{{ route('cms.team.destroy', $member->id) }}" onsubmit="return confirm('Hapus anggota ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="border border-red-200 px-3 py-2 text-xs font-semibold text-red-600 transition hover:bg-red-50">Hapus</button>
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
