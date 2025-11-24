<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConfigurationTest extends TestCase
{
   public function testConfig()
   {
    $firstName = config('contoh.author.first');
    $lastName = config('contoh.author.last');
    $email = config('contoh.email');
    $web = config('contoh.web');

    self::assertEquals('Ivriel', $firstName);
    self::assertEquals('Gunawan', $lastName);
    self::assertEquals('gunawanivriel@gmail.com', $email);
    self::assertEquals('www.shankarapaperstraw.com', $web);
   }
}
