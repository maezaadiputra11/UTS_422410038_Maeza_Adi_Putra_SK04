@extends('layouts.app')

@section('title', $item->exists ? 'Edit Format Media' : 'Tambah Format Media')

@section('content')
    <header class="page-header">
        <h1>{{ $item->exists ? 'Edit Format Media' : 'Tambah Format Media' }}</h1>
    </header>

    <x-card>
        <form action="{{ $item->exists ? route('format-media.update', $item) : route('format-media.store') }}" method="POST">
            @csrf
            @if ($item->exists)
                @method('PUT')
            @endif

            <x-form.input label="Kode" name="kode" :value="$item->kode" />
            <x-form.input label="Nama Format" name="nama" :value="$item->nama" />
            <x-form.textarea label="Keterangan" name="keterangan" :value="$item->keterangan" />

            <div class="actions">
                <x-button type="submit" variant="success">{{ $item->exists ? 'Perbarui' : 'Simpan' }}</x-button>
                <x-button :href="route('format-media.index')" variant="secondary">Batal</x-button>
            </div>
        </form>
    </x-card>
@endsection
