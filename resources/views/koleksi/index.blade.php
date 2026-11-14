@extends('layouts.app')

@section('title', 'Koleksi Pita')

@section('content')
    <header class="page-header">
        <div>
            <h1>Koleksi Pita</h1>
            <p>Cari dan saring koleksi berdasarkan kode/nama, format, kondisi, atau tindakan restorasi.</p>
        </div>
        <x-button :href="route('koleksi.create')">+ Tambah Koleksi</x-button>
    </header>

    <x-card title="Pencarian & Filter">
        <form method="GET" action="{{ route('koleksi.index') }}" class="filter-bar">
            <div>
                <label for="q">Kata kunci</label>
                <input id="q" type="search" name="q" value="{{ request('q') }}" placeholder="Kode atau nama koleksi">
            </div>
            <div>
                <label for="format_media_id">Format media</label>
                <select id="format_media_id" name="format_media_id">
                    <option value="">Semua</option>
                    @foreach ($formats as $id => $nama)
                        <option value="{{ $id }}" @selected(request('format_media_id') == $id)>{{ $nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="kerusakan">Kerusakan</label>
                <select id="kerusakan" name="kerusakan">
                    <option value="">Semua</option>
                    @foreach (['ringan', 'sedang', 'berat'] as $tingkat)
                        <option value="{{ $tingkat }}" @selected(request('kerusakan') === $tingkat)>{{ ucfirst($tingkat) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="tindakan_id">Tindakan</label>
                <select id="tindakan_id" name="tindakan_id">
                    <option value="">Semua</option>
                    @foreach ($tindakans as $id => $nama)
                        <option value="{{ $id }}" @selected(request('tindakan_id') == $id)>{{ $nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="actions">
                <x-button type="submit">Cari</x-button>
                <x-button :href="route('koleksi.index')" variant="secondary">Reset</x-button>
            </div>
        </form>
    </x-card>

    <x-card>
        <x-table>
            <x-slot:head>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Format</th>
                    <th>Kondisi</th>
                    <th>Tindakan</th>
                    <th>Aksi</th>
                </tr>
            </x-slot:head>

            @forelse ($koleksis as $koleksi)
                <tr>
                    <td>{{ $koleksi->kode }}</td>
                    <td>{{ $koleksi->nama }}</td>
                    <td>{{ $koleksi->formatMedia->nama }}</td>
                    <td>
                        @if ($koleksi->kondisiAwal)
                            <x-badge :variant="$koleksi->kondisiAwal->warna_kerusakan">
                                {{ ucfirst($koleksi->kondisiAwal->tingkat_kerusakan) }}
                            </x-badge>
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $koleksi->tindakan_restorasis_count }} tindakan</td>
                    <td>
                        <div class="actions">
                            <x-button :href="route('koleksi.show', $koleksi)" variant="secondary" class="btn-sm">Detail</x-button>
                            <x-button :href="route('koleksi.edit', $koleksi)" class="btn-sm">Edit</x-button>
                            <form action="{{ route('koleksi.destroy', $koleksi) }}" method="POST"
                                  onsubmit="return confirm('Hapus koleksi ini beserta kondisi dan rencana tindakannya?')">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" variant="danger" class="btn-sm">Hapus</x-button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        <x-empty-state title="Tidak ada koleksi" description="Coba ubah kata kunci/filter atau tambahkan koleksi baru." />
                    </td>
                </tr>
            @endforelse
        </x-table>

        {{ $koleksis->links() }}
    </x-card>
@endsection
