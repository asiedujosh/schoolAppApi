<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ImageCompressor;

class ImageCompressorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->singleton(ImageCompressor::class, function ($app) {
            return new ImageCompressor();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
