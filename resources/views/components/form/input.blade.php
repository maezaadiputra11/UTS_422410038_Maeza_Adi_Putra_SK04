@props(['label', 'name', 'type' => 'text', 'value' => null])

@php
    // Nama bertitik (kondisi.catatan) -> nama HTML array (kondisi[catatan]) agar cocok dengan validasi Laravel.
    $htmlName = preg_replace('/\.(\w+)/', '[$1]', $name);
    $htmlId = str_replace('.', '_', $name);
@endphp

<div class="form-group">
    <label for="{{ $htmlId }}">{{ $label }}</label>
    <input id="{{ $htmlId }}" name="{{ $htmlName }}" type="{{ $type }}" value="{{ old($name, $value) }}" {{ $attributes }}>
    @error($name)
        <small class="error">{{ $message }}</small>
    @enderror
</div>
