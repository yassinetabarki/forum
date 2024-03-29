<?php

namespace Tests\Feature;

use App\Activity;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadTest extends TestCase
{
    use DatabaseMigrations;

/**
 * @test
 */
    public function a_guest_may_not_create_thread()
    {

        $this->withExceptionHandling()
            ->post('/threads')
            ->assertRedirect('login');

        $this->withExceptionHandling()
            ->get('/threads/create')
            ->assertRedirect('login');

    }
    /**
     * @test
     */
    public function an_authenticated_user_can_create_a_new_forum()
    {
        //Given we have a sign in user
        //When hit the end point
        //Then when we visit the thread page
        //We should see the new thread
        $this->signIn();

        $thread=make('App\Thread');

        $response=$this->post('/threads',$thread->toArray());
        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
    /**
     * @test
    */
    public function a_thread_is_required_a_title()
    {
        $this->publishThread(['title'=>null])
             ->assertSessionHasErrors('title');
    }

    /**
     * @test
    */
    public function a_thread_is_required_a_body()
    {
        $this->publishThread(['body'=>null])
        
            ->assertSessionHasErrors('body');
    }

    /**
     * @test
     */
    public function a_thread_is_required_a_valid_channel()
    {
        factory('App\Channel',2)->create();

       $this->publishThread(['channel_id'=>null])
            ->assertSessionHasErrors('channel_id');

       $this->publishThread(['channel_id'=>999])
            ->assertSessionHasErrors('channel_id');
    }
    /** @test*/
    public function unauthorized_users_may_not_delete_threads()
    {

        $thread=create('App\Thread');
        $this->delete($thread->path())->assertRedirect('/login');
        $this->signIn();
        $this->delete($thread->path())->assertStatus(403);
    }
    /** @test*/
    public function authorized_users_can_deleted_threads()
    {
        $this->signIn();
        $thread=create('App\Thread',['user_id'=>auth()->id()]);
        $reply=create('App\Reply',['thread_id'=> $thread->id]);
        $response=$this->json('DELETE',$thread->path());
        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads',['id'=> $thread->id]);
        $this->assertDatabaseMissing('replies',['id'=> $reply->id]);
        $this->assertEquals(0,Activity::count());
        
    }

    public function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();
        $thread=make('App\Thread',$overrides);
        return $this->post('/threads',$thread->toArray());
    }
    
}
