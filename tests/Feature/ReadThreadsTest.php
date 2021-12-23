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
    /** 
     * @test
     * */
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

       /** @test  */
       public function a_user_can_filter_threads_by_answere(){

        $thread=create('App\Thread');
        
        create('App\Reply',['thread_id' => $thread->id]);

        $response=$this->getJson('threads?unanswered=1')->json();

        $this->assertCount(1,$response);

    }

    /** 
     * @test
     */
    public function a_user_can_request_all_replies_for_a_given_thread(){

        $thread=create('App\Thread');

        create('App\Reply', ['thread_id' => $thread->id] ,2);

        $response= $this->getJson($thread->path() . '/replies')->json();

        $this->assertCount(2,$response['data']);
        $this->assertEquals(2,$response['total']);
    }

 
}
