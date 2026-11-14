<div class="table-responsive">
    <table {{ $attributes->class(['table']) }}>
        @isset($head)
            <thead>{{ $head }}</thead>
        @endisset
        <tbody>
            {{ $slot }}
        </tbody>
    </table>
</div>
