<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResponseControllerTest extends TestCase
{
    public function testResponse()
    {
        $this->get('/response/hello')
        ->assertStatus(200)
        ->assertSeeText('Hello Response');
    }

    public function testHeader()
    {
        $this->get('/response/header')
        ->assertStatus(200)
        ->assertSeeText('Ivriel')
        ->assertSeeText('Gunawan')
        ->assertHeader('Content-Type','application/json')
        ->assertHeader('Author','Ivriel')
        ->assertHeader('App','Belajar Laravel');
    }

    public function testView()
    {
        $this->get('/response/type/view')
        ->assertSeeText('Hello Ivriel');
    }

    public function testJson()
    {
        $this->get('/response/type/json')
        ->assertJson([
            "firstName" => "Ivriel",
            "lastName"=>"Gunawan"
        ]);
    }

    public function testFile()
    {
        $this->get("/response/type/file")->assertHeader('Content-Type','image/jpeg');
    }
    
    public function testDownload()
    {
        $this->get('/response/type/download')->assertDownload('kisspng-cascading-style-sheets-h.jpg');
    }
}
