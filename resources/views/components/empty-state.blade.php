@props(['title' => 'Belum ada data', 'description' => null])

<div class="empty-state">
    <h3>{{ $title }}</h3>
    @if ($description)
        <p>{{ $description }}</p>
    @endif
    {{ $slot }}
</div>
