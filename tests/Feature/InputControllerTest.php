<?php

namespace Tests\Feature;

use Illuminate\Http\Request;
use Tests\TestCase;

class InputControllerTest extends TestCase
{
    public function testInput()
    {
        $this->get('/input/hello?name=Ivriel')->assertSeeText('Hello Ivriel');
        $this->post('/input/hello', ['name' => 'Ivriel'])->assertSeeText('Hello Ivriel');
    }

    public function testInputNested()
    {
        $this->post('/input/hello/first',[
            "name"=>[
                "first"=>"Ivriel",
                "last"=>"Gunawan"
            ]
        ])->assertSeeText("Hello Ivriel");
    }

    public function testInputAll()
    {
        $this->post('/input/hello/input',[
            "name"=>[
                "first"=>"Ivriel",
                "last"=>"Gunawan"
            ]
        ])->assertSeeText("name")->assertSeeText("first")
        ->assertSeeText("last")->assertSeeText("Ivriel")
        ->assertSeeText("Gunawan");
    }

     public function testInputArray()
    {
        $this->post('/input/hello/array',[
            "products"=>[
                [
                    "name"=>"ZX 10 RR",
                    "price"=>500000000
                ],
                [
                    "name"=> "Ducati Superleggera V4",
                    "price"=> 15000000
                ]
            ]
        ])->assertSeeText("ZX 10 RR")->assertSeeText("Ducati Superleggera V4");
    }

    public function testInputType()
    {
        $this->post('/input/type',[
            'name'=>'Ivriel',
            'married'=>'true',
            'birth_date'=>'2002-11-19'
        ])->assertSeeText("Ivriel")->assertSeeText("true")->assertSeeText("2002-11-19");
    }

    public function testFilterOnly()
    {
      $this->post('/input/filter/only',[
        "name"=>[
            "first"=>"Ivriel",
            "middle"=> "Dei Gratia",
            "last"=>"Gunawan"
        ]
      ])->assertSeeText("Ivriel")->assertSeeText("Gunawan")->assertDontSeeText("Dei Gratia");
    }
 
    public function testFilterExcept()
    {
          $this->post('/input/filter/except',[
        "username"=>"Ivriel",
        "password"=>"123456",
        "admin"=>"true"
      ])->assertSeeText("Ivriel")->assertSeeText("123456")->assertDontSeeText("admin");
    }

    public function testFilterMerge(){
        $this->post('/input/filter/merge',[
        "username"=>"Ivriel",
        "password"=>"123456",
        "admin"=>"true"
      ])->assertSeeText("Ivriel")->assertSeeText("123456")->assertSeeText("false");
    }
}
