<?php

namespace Tests\Feature;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;




class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    private $thread;
    public function setUp()
    {
        parent::setUp();
        $this->thread=factory('App\Thread')->create();
    }
    /**
     * @test
    */
    public function a_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection',$this->thread->replies);
    }

    /**
     * @test
    */
    public function a_thread_has_owner(){
        $this->assertInstanceOf('App\User',$this->thread->creator);
    }

    /**
     * @test
    */
    public function a_thread_can_add_reply()
    {
    $this->thread->addReply([
        'body'=>'foobar',
        'user_id'=> 1
    ]);
    $this->assertCount(1,$this->thread->replies);
    }

    /**
     * @test
    */
    public function a_thread_belong_to_a_channel()
    {
     $thread=create('App\Thread');

     $this->assertInstanceOf('App\Channel',$thread->channel);
    }

    /**
     * @test
     */
    public function a_thread_can_make_a_string_path()
    {
        $thread=create('App\Thread');
        $this->assertEquals("/threads/{$thread->channel->slug}/".$thread->id,$thread->path());
    }
}
