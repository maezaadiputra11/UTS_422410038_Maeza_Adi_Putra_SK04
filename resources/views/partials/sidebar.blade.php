<aside class="sidebar">
    <a href="{{ route('dashboard') }}" @class(['nav-link', 'active' => request()->routeIs('dashboard')])>Dashboard</a>
    <a href="{{ route('koleksi.index') }}" @class(['nav-link', 'active' => request()->routeIs('koleksi.*')])>Koleksi Pita</a>
    <a href="{{ route('format-media.index') }}" @class(['nav-link', 'active' => request()->routeIs('format-media.*')])>Format Media</a>
    <a href="{{ route('tindakan-restorasi.index') }}" @class(['nav-link', 'active' => request()->routeIs('tindakan-restorasi.*')])>Tindakan Restorasi</a>
</aside>
