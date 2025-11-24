<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class FacadeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testConfig()
    {
       $firstName1 = Config('contoh.author.first');
       $firstName2 = Config::get('contoh.author.first');

       self::assertEquals($firstName1, $firstName2);
       var_dump(Config::all());
    }

    public function testConfigDependency()
    {
        $config = $this->app->make('config');
        $firstName3 = $config->get('contoh.author.first');

        $firstName1 = config('contoh.author.first');
        $firstName2 = config('contoh.author.first');

        self::assertEquals($firstName1, $firstName2);
        var_dump(Config::all());
    }

    public function testFacadeMock()
    {
        Config::shouldReceive('get')->with('contoh.author.first')->andReturn('Ivriel Gunawan');
        $firstName = Config::get('contoh.author.first');

        self::assertEquals('Ivriel Gunawan',$firstName);
    }
}
