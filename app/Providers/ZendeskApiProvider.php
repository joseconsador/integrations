<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

/**
 * Class ZendeskApiProvider
 */
class ZendeskApiProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('zendesk.api', function () {
            // Implement
            // return new ZendeskApi();
        });
    }
}
