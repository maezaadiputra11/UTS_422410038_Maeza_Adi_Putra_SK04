<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Template pagination sendiri (tanpa Tailwind/Vite), lihat resources/views/vendor/pagination/pita.blade.php
        Paginator::defaultView('vendor.pagination.pita');
    }
}
