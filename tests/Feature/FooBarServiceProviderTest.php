<?php

namespace Tests\Feature;

use App\Data\Bar;
use App\Data\Foo;
use App\Services\HelloService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FooBarServiceProviderTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testServiceProvider()
    {
       // register singletons in the container for this test
       $this->app->singleton(Foo::class, function($app){
           return new Foo();
       });

       $this->app->singleton(Bar::class, function($app){
           return new Bar($app->make(Foo::class));
       });

       $foo1 = $this->app->make(Foo::class);
       $foo2 = $this->app->make(Foo::class);

       self::assertSame($foo1,$foo2);
       $bar1 = $this->app->make(Bar::class);
       $bar2 = $this->app->make(Bar::class);

       self::assertSame($bar1,$bar2);
    }

    public function testPropertySingletons()
    {
        $helloService1= $this->app->make(HelloService::class);
        $helloService2= $this->app->make(HelloService::class);

        self::assertSame($helloService1,$helloService2);

        self::assertEquals('Hallo Ivriel', $helloService1->hello('Ivriel'));
    }
}
