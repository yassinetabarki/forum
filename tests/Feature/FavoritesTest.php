<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoritesTest extends TestCase
{

    use RefreshDatabase;

    /** @test*/
    public function a_gust_can_not_favorite_reply()
    {

        $this->post('/replies/1/favorites')
            ->assertRedirect('/login');
    }
    /** @test*/
    public function authenticated_user_may_favorites_replies()
    {
        $this->signIn();
        $replie=create('App\Reply');
        $this->post('/replies/'.$replie->id.'/favorites');
        $this->assertCount(1,$replie->favorites);
    }
    /** @test*/
    public function authenticated_user_may_unfavorites_replies()
    {
        $this->signIn();
        $reply=create('App\Reply');
        $this->post('/replies/'.$reply->id.'/favorites');
        $this->delete('/replies/'.$reply->id.'/favorites');
        $this->assertCount(0,$reply->favorites);

    }

    /** @test*/
    public function authenticated_user_may_only_favorites_reply_once()
    {
        $this->withoutExceptionHandling();

        $this->signIn();
        $replie=create('App\Reply');
        $this->post('/replies/'.$replie->id.'/favorites');
        $this->post('/replies/'.$replie->id.'/favorites');
        $this->post('/replies/'.$replie->id.'/favorites');
        $this->assertCount(1,$replie->favorites);
    }
    /** @test*/
    public function authenticated_user_cannot_delele_there_thread_by_repling()
    {
        $this->signIn();
        $reply=create('App\Reply',['user_id'=>auth()->id()]);
        $this->post('/replies/'.$reply->id.'/favorites');
        $this->assertCount(1,$reply->favorites);
        $this->delete('/replies/'.$reply->id.'/favorites');
        $this->assertDatabaseHas('replies',['id'=>$reply->id]);
    }

}
