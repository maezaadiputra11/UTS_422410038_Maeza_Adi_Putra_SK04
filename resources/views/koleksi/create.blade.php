@extends('layouts.app')

@section('title', 'Tambah Koleksi')

@section('content')
    <header class="page-header">
        <div>
            <h1>Tambah Koleksi</h1>
            <p>Isi data koleksi, kondisi awal, dan rencana tindakan restorasi.</p>
        </div>
    </header>

    @include('koleksi._form')
@endsection
