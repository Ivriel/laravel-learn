<?php

namespace Tests\Feature;

use App\Data\Bar;
use App\Data\Foo;
use App\Data\Person;
use App\Services\HelloService;
use App\Services\HelloServiceIndonesia;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class ServiceContainerTest extends TestCase
{
   public function testDependency()
   {
    $foo1 = $this->app->make(Foo::class);
    $foo2 = $this->app->make(Foo::class);

    self::assertEquals('Foo',$foo1->foo());
    self::assertEquals('Foo',$foo2->foo());
    self::assertNotSame($foo1,$foo2);
   }

   public function testBind()
   {
    // $person = $this->app->make(Person::class);
    // self::assertNotNull($person);

    $this->app->bind(Person::class,function($app){
        return new Person("Ivriel","Gunawan");
    });

    $person1 = $this->app->make(Person::class);
    $person2 = $this->app->make(Person::class);

    self::assertEquals('Ivriel',$person1->firstName);
    self::assertEquals('Ivriel', $person2->firstName);
    self::assertNotSame($person1,$person2);
   }

    public function testSingleton()
   {
    // $person = $this->app->make(Person::class);
    // self::assertNotNull($person);

    $this->app->singleton(Person::class,function($app){
        return new Person("Ivriel","Gunawan");
    });

    $person1 = $this->app->make(Person::class);
    $person2 = $this->app->make(Person::class);

    self::assertEquals('Ivriel',$person1->firstName);
    self::assertEquals('Ivriel', $person2->firstName);
    self::assertSame($person1,$person2);
   }

   public function testInstance()
   {
    // $person = $this->app->make(Person::class);
    // self::assertNotNull($person);
    $person = new Person("Ivriel","Gunawan");

    $this->app->instance(Person::class,$person);

    $person1 = $this->app->make(Person::class);
    $person2 = $this->app->make(Person::class);

    self::assertEquals('Ivriel',$person1->firstName);
    self::assertEquals('Ivriel', $person2->firstName);
    self::assertSame($person1,$person2);
   }

   public function testDependencyInjection()
   {

    $this->app->singleton(Foo::class,function($app){
        return new Foo();
    });

    $this->app->singleton(Bar::class,function($app){
        $foo = $app->make(Foo::class);
        return new Bar($foo);
    });
    $foo = $this->app->make(Foo::class);
    $bar = $this->app->make(Bar::class);

    self::assertSame($foo,$bar->foo);
   }

   public function testInterfaceToClass()
   {
    $this->app->singleton(HelloService::class,HelloServiceIndonesia::class);

    $helloService = $this->app->make(HelloService::class);
    self::assertEquals('Hallo Ivriel',$helloService->hello('Ivriel'));
   }

}
