<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Policies\ViewNewSamplesPolicy;
use App\ViewNewSamples;
use App\Policies\AdminPolicy;
use App\Admin;
use App\ViewNewPhytos1;
use App\Policies\ViewNewPhytos1Policy;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        ViewNewSamples::class => ViewNewSamplesPolicy::class,
        Admin::class => AdminPolicy::class,
        ViewNewPhytos1::class => ViewNewPhytos1Policy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
