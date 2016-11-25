<?php
namespace App\Providers;

use App\Utilities\ZendeskUrl;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class ZendeskUrlProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     * 
     * @return void
     */
    public function boot()
    {
        //
    }
    
     /**
     * Register the application services
     * 
     * @return void
     */   
    public function register()
    {
       App::bind('zendesk.url', function () {
           return new ZendeskUrl();
       });
    }
}