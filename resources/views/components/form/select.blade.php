@props(['label', 'name', 'options' => [], 'selected' => null, 'placeholder' => null])

@php
    $htmlName = preg_replace('/\.(\w+)/', '[$1]', $name);
    $htmlId = str_replace('.', '_', $name);
@endphp

<div class="form-group">
    <label for="{{ $htmlId }}">{{ $label }}</label>
    <select id="{{ $htmlId }}" name="{{ $htmlName }}" {{ $attributes }}>
        @if ($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        @foreach ($options as $value => $text)
            <option value="{{ $value }}" @selected((string) old($name, $selected) === (string) $value)>{{ $text }}</option>
        @endforeach
    </select>
    @error($name)
        <small class="error">{{ $message }}</small>
    @enderror
</div>
