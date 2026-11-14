@props(['title', 'value' => 0, 'description' => null])

<article {{ $attributes->class(['stat-card']) }}>
    <p class="stat-title">{{ $title }}</p>
    <strong class="stat-value">{{ $value }}</strong>
    @if ($description)
        <small>{{ $description }}</small>
    @endif
</article>
