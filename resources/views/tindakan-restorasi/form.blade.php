@extends('layouts.app')

@section('title', $item->exists ? 'Edit Tindakan' : 'Tambah Tindakan')

@section('content')
    <header class="page-header">
        <h1>{{ $item->exists ? 'Edit Tindakan Restorasi' : 'Tambah Tindakan Restorasi' }}</h1>
    </header>

    <x-card>
        <form action="{{ $item->exists ? route('tindakan-restorasi.update', $item) : route('tindakan-restorasi.store') }}" method="POST">
            @csrf
            @if ($item->exists)
                @method('PUT')
            @endif

            <x-form.input label="Nama Tindakan" name="nama" :value="$item->nama" />
            <x-form.textarea label="Deskripsi" name="deskripsi" :value="$item->deskripsi" />
            <x-form.input label="Estimasi (jam)" name="estimasi_jam" type="number" :value="$item->estimasi_jam" />

            <label class="check">
                <input type="checkbox" name="aktif" value="1" @checked(session()->hasOldInput() ? old('aktif') : $item->aktif)> Aktif (dapat dipilih pada rencana restorasi)
            </label>

            <div class="actions">
                <x-button type="submit" variant="success">{{ $item->exists ? 'Perbarui' : 'Simpan' }}</x-button>
                <x-button :href="route('tindakan-restorasi.index')" variant="secondary">Batal</x-button>
            </div>
        </form>
    </x-card>
@endsection
