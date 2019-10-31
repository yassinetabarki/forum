<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * @property  thread
 */
class ReadThreadsTest extends TestCase
{

    use DatabaseMigrations;

    protected $thread;

    public function setUp()
    {
        parent::setUp();
        $this->thread=factory('App\Thread')->create();
    }

    /**
     * @test
     */
    public function a_user_can_browse_threads()
    {
        $response = $this->get('threads');
        $response->assertSee($this->thread->title);


    }
    /**
     * @test
     */
    public function a_user_can_read_single_thread()
    {
        $response = $this->get($this->thread->path());
        $response->assertSee($this->thread->title);
    }

    /**
     * @test
     */
    public function a_user_can_see_replys_for_thread()
    {
        $reply=factory('App\Reply')->create(['thread_id' => $this->thread->id]);

        $this->get($this->thread->path())
             ->assertSee($reply->body);
    }
    /**
     * @test
     */
    public function a_user_see_threads_according_to_tag()
    {
        $channel=create('App\Channel');
        $threadInChannel=create('App\Thread',['channel_id'=>$channel->id]);
        $threadNotInChannel=create('App\Thread');
        $this->get('/threads/'.$channel->slug)
             ->assertSee($threadInChannel->title)
             ->assertDontSee($threadNotInChannel->title);
    }

    /**
    * @test
    */
    public function a_user_can_filter_a_thread_by_user_name()
    {

        $this->signIn(create('App\User',['name'=>'yassine']));

        $yassineThread=create('App\Thread',['user_id'=>auth()->id()]);

        $notYassineThread=create('App\Thread');

        $this->get('threads?by=yassine')
             ->assertSee($yassineThread->title)
             ->assertDontSee($notYassineThread->title);
    }
    /** @test*/
    public function a_user_can_filter_threads_by_popularity()
    {
        $threadwithTowReplies=create('App\Thread');
        create('App\Reply',['thread_id'=>$threadwithTowReplies->id],2);

        $threadwithThreeReplies=create('App\Thread');
        create('App\Reply',['thread_id'=>$threadwithThreeReplies->id],3);

        $threadwithZeroReplies=$this->thread;

        $response=$this->getJson('threads?popular=1')->json();

        $this->assertEquals([3,2,0],array_column($response,'replies_count'));
    }
}
