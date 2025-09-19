<?php

namespace App\Providers;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // if (env('APP_ENV') === 'production') {
        //     URL::forceScheme('https');
        // }
        if (Schema::hasTable('users') && DB::table('users')->count() === 0) {
            $seeder = new DatabaseSeeder();
            $seeder->run();
        }
    }
}
