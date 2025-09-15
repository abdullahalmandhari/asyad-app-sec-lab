<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\Shipment;
use App\Policies\ShipmentPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /** @var array<class-string, class-string> */
    protected $policies = [
        Shipment::class => ShipmentPolicy::class,
        // add more model => policy pairs as you create them
    ];

    public function boot(): void
    {
        // nothing else required; Gate registers policies automatically
    }
}
