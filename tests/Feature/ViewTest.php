<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTest extends TestCase
{
   
    public function testView()
    {
        $this->get('/hello')->assertSeeText('Hello Ivriel');
        $this->get('/hello-again')->assertSeeText('Hello Ivriel Gunawan');  
    }

    public function testNested()
    {
        $this->get('/hello-world')->assertSeeText('World Ivriel Gunawann');
    }

    public function testName()
    {
        $this->view('hello',['name'=>'Ivriel'])->assertSeeText('Hello Ivriel');

        $this->view('hello.world',['name'=>'Ivriel'])->assertSeeText('World Ivriel');
    }
}
