<?php

namespace Tests\Unit;

use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

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

    /** @test */
    public function a_thread_notifies_all_registered_subscribers_when_a_reply_is_added (){
        
        Notification::fake();

        $this->signIn()
        ->thread
        ->subscribe()
        ->addReply([
            'body'=>'foobar',
            'user_id'=> 99
        ]);

        Notification::assertSentTo(auth()->user(),ThreadWasUpdated::class);
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
    /** @test */
    public function a_thread_can_be_subscribed_to()
    {
        $thread=create('App\Thread');

        $this->signIn();

        $thread->subscribe();

        $this->assertEquals(1,$thread->subscriptions()->where('user_id',auth()->id())->count());
    }

        /** @test */
        public function a_thread_can_be_unsubscribed_to ()
        {
            $thread=create('App\Thread');
            $thread->subscribe($userId=1);
            
            $thread->unsubscribe($userId);
    
            $this->assertCount(0,$thread->subscriptions);
        }

        /** @test */
        public function check_if_th_authenticated_user_is_subscribed ()
        {   
                $thread=create('App\Thread');
                
                $this->signIn();

                $thread->subscribe();

                $this->assertTrue($thread->isSubscribedTo);
        }

}
