<?php

namespace Hanoivip\PaymentMethodPagar;

use Illuminate\Support\ServiceProvider;

class LibServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../lang' => resource_path('lang/vendor/hanoivip'),
            __DIR__.'/../config' => config_path(),
        ]);
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        //$this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadTranslationsFrom( __DIR__.'/../lang', 'hanoivip.pagar');
        $this->loadViewsFrom(__DIR__ . '/../views', 'hanoivip');
    }
    
    public function register()
    {
        $this->commands([
        ]);
        $this->app->bind("PagarMethod", PagarMethod::class);
        $this->app->bind(IHelper::class, PagarApi::class);
    }
}
