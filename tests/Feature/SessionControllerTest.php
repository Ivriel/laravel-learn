<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SessionControllerTest extends TestCase
{
    public function testCreateSession()
    {
       $this->get('/session/create')
       ->assertSeeText("OK")
       ->assertSessionHas("userId","Ivriel")
       ->assertSessionHas("isMember",true);
    }

    public function testGetSession()
    {
        $this->withSession([
            "userId"=>"ivriel", 
            "isMember"=>"true"
        ])->get('/session/get')->assertSeeText("User Id : ivriel, Is Member : true"); // boolean akan selalu di render jadi 0 atau 1 tergantung dari valuenya
    }

    public function testGetSessionFailed()
    {
         $this->withSession([])->get('/session/get')->assertSeeText("User Id : guest, Is Member : false");
    }
    
}
