@extends('layouts.app')

@section('title', $koleksi->nama)

@section('content')
    <header class="page-header">
        <div>
            <h1>{{ $koleksi->nama }}</h1>
            <p>{{ $koleksi->kode }} &middot; {{ $koleksi->formatMedia->nama }}</p>
        </div>
        <div class="actions">
            <x-button :href="route('koleksi.edit', $koleksi)">Edit</x-button>
            <x-button :href="route('koleksi.index')" variant="secondary">Kembali</x-button>
        </div>
    </header>

    <x-card title="Data Koleksi">
        <dl class="detail-list">
            <dt>Kode</dt><dd>{{ $koleksi->kode }}</dd>
            <dt>Format media</dt><dd>{{ $koleksi->formatMedia->nama }}</dd>
            <dt>Tahun rekaman</dt><dd>{{ $koleksi->tahun_rekaman ?? '-' }}</dd>
            <dt>Deskripsi</dt><dd>{{ $koleksi->deskripsi ?? '-' }}</dd>
        </dl>
    </x-card>

    <x-card title="Kondisi Awal">
        @if ($koleksi->kondisiAwal)
            @php $k = $koleksi->kondisiAwal; @endphp
            <dl class="detail-list">
                <dt>Tingkat kerusakan</dt>
                <dd><x-badge :variant="$k->warna_kerusakan">{{ ucfirst($k->tingkat_kerusakan) }}</x-badge></dd>
                <dt>Jamur</dt><dd>{{ $k->ada_jamur ? 'Ya' : 'Tidak' }}</dd>
                <dt>Sticky-shed</dt><dd>{{ $k->sticky_shed ? 'Ya' : 'Tidak' }}</dd>
                <dt>Tanggal periksa</dt><dd>{{ $k->tanggal_periksa?->format('d-m-Y') ?? '-' }}</dd>
                <dt>Catatan</dt><dd>{{ $k->catatan ?? '-' }}</dd>
            </dl>
        @else
            <x-empty-state title="Kondisi awal belum diisi" />
        @endif
    </x-card>

    <x-card title="Rencana Tindakan Restorasi">
        <x-table>
            <x-slot:head>
                <tr>
                    <th>Tindakan</th>
                    <th>Estimasi</th>
                    <th>Prioritas</th>
                    <th>Status</th>
                </tr>
            </x-slot:head>
            @forelse ($koleksi->tindakanRestorasis->sortBy('pivot.prioritas') as $t)
                @php
                    $varian = match ($t->pivot->status) {
                        'selesai' => 'success',
                        'berjalan' => 'warning',
                        default => 'secondary',
                    };
                @endphp
                <tr>
                    <td>{{ $t->nama }}</td>
                    <td>{{ $t->estimasi_jam }} jam</td>
                    <td>{{ $t->pivot->prioritas }}</td>
                    <td><x-badge :variant="$varian">{{ ucfirst($t->pivot->status) }}</x-badge></td>
                </tr>
            @empty
                <tr><td colspan="4">Belum ada rencana tindakan.</td></tr>
            @endforelse
        </x-table>
        <p><strong>Total estimasi:</strong> {{ $koleksi->tindakanRestorasis->sum('estimasi_jam') }} jam</p>
    </x-card>
@endsection
