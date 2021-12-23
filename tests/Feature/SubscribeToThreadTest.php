<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscribeToThreadTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase ;

    /** @test */
    public function a_user_can_subscribe_to_thread()
    { 
        $this->withoutExceptionHandling();
        $this->signIn();
        //Given we have a thread
        $thread = create("App\Thread");
        // and the user subscribe to the thread...
        $this->post($thread->path() . '/subscriptions');
        // then , each time a new reply is left..
        // $this->assertCount(0,auth()->user()->notifications);
        // $thread->addReply([
        //     'user_id' => auth()->id(),
        //     'body' => 'some reply here'
        // ]);

        // //  A notification should be prepared for the user 

        // $this->assertCount(1,auth()->user()->fresh()->notifications);

        $this->assertCount(1, $thread->fresh()->subscriptions);
       

    }


    /** @test */
    public function a_user_can_unsubscibe_to_thread ()
    {
        $this->signIn();
        //Given we have a thread
        $thread = create("App\Thread");
        
        $thread->subscribe();
        // and the user subscribe to the thread...
        $this->delete($thread->path().'/subscriptions');
        
        $this->assertCount(0, $thread->subscriptions);

    }       
}
