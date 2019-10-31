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
        $this->get($thread->path())
            ->assertSee($reply->body);
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
}
