@props(['label', 'name', 'value' => null])

@php
    $htmlName = preg_replace('/\.(\w+)/', '[$1]', $name);
    $htmlId = str_replace('.', '_', $name);
@endphp

<div class="form-group">
    <label for="{{ $htmlId }}">{{ $label }}</label>
    <textarea id="{{ $htmlId }}" name="{{ $htmlName }}" {{ $attributes }}>{{ old($name, $value) }}</textarea>
    @error($name)
        <small class="error">{{ $message }}</small>
    @enderror
</div>
