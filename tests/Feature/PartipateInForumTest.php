<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;


class PartipateInForumTest extends TestCase
{
    use DatabaseMigrations;

/**
 * @test
*/
    public function unauthenticated_users_may_not_add_replies()
    {
        $this->withExceptionHandling()
        ->post('/threads/some-channel/1/replies',[])
        ->assertRedirect('login');
    }
    /**
     * @test
    */
    public function an_authenticated_user_may_paticiptate_in_forum_thread()
    {
        //Given we have an authenticated user
        $this->signIn();
        //And an existing thread
        $thread=create('App\Thread');
        // when the user add the reply to the thread
        $reply=create('App\Reply');

        $this->post($thread->path().'/replies',$reply->toArray());

        // then the reply should be visible to the user
        // $this->get($thread->path())->assertSee($reply->body);
        $this->assertDatabaseHas('replies',['body' => $reply->body]);

        $this->assertEquals(1, $thread->fresh()->replies_count); 
    }

    /**
     * @test
    */
    public function a_replies_must_have_body()
    {
        $this->withExceptionHandling()->signIn();

        $thread=create('App\Thread');

        $reply=make('App\Reply',['body'=>null]);

        $this->post($thread->path().'/replies',$reply->toArray())
            ->assertSessionHasErrors('body');

    }
    /** @test*/
    public function unauthorized_users_cannot_delete_replies()
    {
        $reply=create('App\Reply');
        $this->delete("/replies/{$reply->id}")
            ->assertRedirect('login');
        $this->signIn();
        $this->delete("/replies/{$reply->id}")
            ->assertStatus(403);
    }
    /** @test*/
    public function authorized_users_can_delete_replies()
    {
        $user=$this->signIn();
        $reply=create('App\Reply',['user_id' =>auth()->id()]);
        $this->delete("/replies/{$reply->id}")->assertStatus(302);
        $this->assertDatabaseMissing('replies',['id'=>$reply->id]);
        $this->assertEquals(0,$reply->thread->fresh()->replies_count);
    }
    /** @test*/
    public function authorized_users_can_update()
    {
        
        $this->signIn();
        $reply=create('App\Reply',['user_id' =>auth()->id()]);
        $this->patch("/replies/{$reply->id}",['body'=>'you have change']);
        $this->assertDatabaseHas('replies',['id'=>$reply->id,'body'=>'you have change']);

    }
    /** @test*/
    public function unauthorized_users_cannot_update_replies()
    {
        $reply=create('App\Reply');
        $this->patch("/replies/{$reply->id}")
            ->assertRedirect('login');
        $this->signIn();
        $this->patch("/replies/{$reply->id}")
            ->assertStatus(403);
    }
}
