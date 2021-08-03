<?php

namespace Hanoivip\PaymentMethodCredit;

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
        $this->loadTranslationsFrom( __DIR__.'/../lang', 'hanoivip');
    }
    
    public function register()
    {
        $this->commands([
            \Hanoivip\PaymentMethodTsr\TestCallback::class,
        ]);
        $this->app->bind("CreditPaymentMethod", CreditMethod::class);
    }
}
