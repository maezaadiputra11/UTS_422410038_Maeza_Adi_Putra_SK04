@extends('layouts.app')

@section('title', 'Format Media')

@section('content')
    <header class="page-header">
        <div>
            <h1>Format Media</h1>
            <p>Kategori pita (reel, kaset, microcassette, dll).</p>
        </div>
        <x-button :href="route('format-media.create')">+ Tambah Format</x-button>
    </header>

    <x-card>
        <x-table>
            <x-slot:head>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Keterangan</th>
                    <th>Koleksi</th>
                    <th>Aksi</th>
                </tr>
            </x-slot:head>
            @forelse ($formats as $format)
                <tr>
                    <td>{{ $format->kode }}</td>
                    <td>{{ $format->nama }}</td>
                    <td>{{ $format->keterangan ?? '-' }}</td>
                    <td>{{ $format->koleksi_pitas_count }}</td>
                    <td>
                        <div class="actions">
                            <x-button :href="route('format-media.edit', $format)" class="btn-sm">Edit</x-button>
                            <form action="{{ route('format-media.destroy', $format) }}" method="POST"
                                  onsubmit="return confirm('Hapus format media ini?')">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" variant="danger" class="btn-sm">Hapus</x-button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5"><x-empty-state title="Belum ada format media" /></td></tr>
            @endforelse
        </x-table>

        {{ $formats->links() }}
    </x-card>
@endsection
