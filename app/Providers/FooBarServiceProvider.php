<?php

namespace App\Providers;

use App\Data\Bar;
use App\Data\Foo;
use App\Services\HelloService;
use Illuminate\Support\ServiceProvider;

class FooBarServiceProvider extends ServiceProvider
{

    public array $singletons = [
        HelloService::class => HelloService::class
    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        echo "FooBarServiceProvider";
        $this->app->singleton(Foo::class,function ($app){
            return new Foo();
        });
        $this->app->singleton(Bar::class,function ($app){
            return new Bar($app->make(Foo::class));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function provides()
    {
        return [HelloService::class,Foo::class,Bar::class];
    }
}
