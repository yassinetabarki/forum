<?php

namespace Tests\Unit;

use App\Inspections\Spam;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpamTest extends TestCase
{
    /**
     *@test    
      */
    public function it_validates_spam()
    {
       $spam = new Spam();

       $this->assertFalse($spam->detect('Innocent Reply here'));

       $this->expectException('Exception');

       $spam->detect('yahoo customer support');


    }

    /** @test */
    public function it_check_for_any_key_being_held_down()
    {
        $spam=new Spam();

        $this->expectException('Exception');


        $spam->detect('hello yassine  aaaaaaa') ;
    }
}
