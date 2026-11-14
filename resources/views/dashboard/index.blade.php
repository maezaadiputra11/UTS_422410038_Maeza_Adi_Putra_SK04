@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <header class="page-header">
        <div>
            <h1>Dashboard</h1>
            <p>Ringkasan koleksi pita rekaman analog yang sedang diarsipkan.</p>
        </div>
        <x-button :href="route('koleksi.create')">+ Tambah Koleksi</x-button>
    </header>

    <section class="stats-grid">
        <x-stat-card title="Total Koleksi" :value="$totalKoleksi" description="Seluruh pita terdata" />
        <x-stat-card title="Kerusakan Berat" :value="$kerusakanBerat" description="Perlu prioritas restorasi" />
        <x-stat-card title="Tindakan Berjalan" :value="$tindakanBerjalan" description="Sedang dikerjakan" />
    </section>

    <div class="stats-grid" style="grid-template-columns: 1fr 1fr; align-items: start;">
        <x-card title="Koleksi per Format Media">
            <x-table>
                <x-slot:head>
                    <tr>
                        <th>Format</th>
                        <th>Jumlah</th>
                    </tr>
                </x-slot:head>
                @forelse ($formats as $format)
                    <tr>
                        <td>{{ $format->nama }}</td>
                        <td>{{ $format->koleksi_pitas_count }}</td>
                    </tr>
                @empty
                    <tr><td colspan="2">Belum ada format media.</td></tr>
                @endforelse
            </x-table>
        </x-card>

        <x-card title="Koleksi Terbaru">
            <x-table>
                <x-slot:head>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Format</th>
                    </tr>
                </x-slot:head>
                @forelse ($terbaru as $koleksi)
                    <tr>
                        <td><a href="{{ route('koleksi.show', $koleksi) }}">{{ $koleksi->kode }}</a></td>
                        <td>{{ $koleksi->nama }}</td>
                        <td>{{ $koleksi->formatMedia->nama }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3">Belum ada koleksi.</td></tr>
                @endforelse
            </x-table>
        </x-card>
    </div>
@endsection
