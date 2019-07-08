<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class GeocodeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        switch (config('geocode.driver')) {
            case 'mock':
                $this->app->singleton(\App\Contracts\Geocoder::class, \App\Geocoders\MockGeocoder::class);
                break;
            case 'google':
                $this->app->singleton(\App\Contracts\Geocoder::class, \App\Geocoders\GoogleGeocoder::class);
                break;
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
