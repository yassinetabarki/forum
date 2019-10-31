<?php

namespace Tests\Feature;

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
}
