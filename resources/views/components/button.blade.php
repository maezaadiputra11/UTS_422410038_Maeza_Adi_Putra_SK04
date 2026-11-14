@props(['href' => null, 'variant' => null])

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class(['btn', "btn-$variant" => $variant]) }}>{{ $slot }}</a>
@else
    <button {{ $attributes->merge(['type' => 'button'])->class(['btn', "btn-$variant" => $variant]) }}>{{ $slot }}</button>
@endif
