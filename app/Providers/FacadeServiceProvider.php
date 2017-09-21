<?php
namespace App\Providers;

use App\Services\LogService;
use Illuminate\Support\ServiceProvider;

class FacadeServiceProvider extends ServiceProvider
{
    protected $defer = false;

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
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('logger', function () {
            return new LogService;
        });


    }

//    public function provides()
//    {
//        return ['logger'];
//    }
}
