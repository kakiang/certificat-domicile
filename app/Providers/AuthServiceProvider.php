<?php

namespace App\Providers;

use App\Models\Certificat;
use App\Policies\CertificatPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider {
    protected $policies = [
        Certificat::class => CertificatPolicy::class,
    ];

    /**
     * Bootstrap services.
     */
    public function boot(): void {
        $this->registerPolicies();
    }

    /**
     * Register services.
     */
    public function register(): void {
        //
    }
}
