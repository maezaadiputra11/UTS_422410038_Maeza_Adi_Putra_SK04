@extends('layouts.app')

@section('title', 'Edit Koleksi')

@section('content')
    <header class="page-header">
        <div>
            <h1>Edit Koleksi</h1>
            <p>{{ $koleksi->kode }} &mdash; {{ $koleksi->nama }}</p>
        </div>
    </header>

    @include('koleksi._form')
@endsection
