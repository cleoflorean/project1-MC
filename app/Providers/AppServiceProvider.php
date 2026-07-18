<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// 1. Tambahkan baris ini di bagian atas:
use Illuminate\Support\Facades\URL; 

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 2. Tambahkan kode ini di dalam fungsi boot:
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}