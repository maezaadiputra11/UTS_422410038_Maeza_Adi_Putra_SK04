@extends('layouts.app')

@section('title', 'Tindakan Restorasi')

@section('content')
    <header class="page-header">
        <div>
            <h1>Tindakan Restorasi</h1>
            <p>Master tindakan yang dapat dipilih pada rencana restorasi koleksi.</p>
        </div>
        <x-button :href="route('tindakan-restorasi.create')">+ Tambah Tindakan</x-button>
    </header>

    <x-card>
        <x-table>
            <x-slot:head>
                <tr>
                    <th>Nama</th>
                    <th>Estimasi</th>
                    <th>Status</th>
                    <th>Dipakai</th>
                    <th>Aksi</th>
                </tr>
            </x-slot:head>
            @forelse ($tindakans as $t)
                <tr>
                    <td>{{ $t->nama }}</td>
                    <td>{{ $t->estimasi_jam }} jam</td>
                    <td>
                        <x-badge :variant="$t->aktif ? 'success' : 'secondary'">{{ $t->aktif ? 'Aktif' : 'Nonaktif' }}</x-badge>
                    </td>
                    <td>{{ $t->koleksi_pitas_count }} koleksi</td>
                    <td>
                        <div class="actions">
                            <x-button :href="route('tindakan-restorasi.edit', $t)" class="btn-sm">Edit</x-button>
                            <form action="{{ route('tindakan-restorasi.destroy', $t) }}" method="POST"
                                  onsubmit="return confirm('Hapus tindakan ini?')">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" variant="danger" class="btn-sm">Hapus</x-button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5"><x-empty-state title="Belum ada tindakan restorasi" /></td></tr>
            @endforelse
        </x-table>

        {{ $tindakans->links() }}
    </x-card>
@endsection
