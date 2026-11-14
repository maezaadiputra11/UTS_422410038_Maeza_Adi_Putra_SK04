@props(['type' => 'info'])

<div role="alert" {{ $attributes->class(['alert', "alert-$type"]) }}>
    {{ $slot }}
</div>
