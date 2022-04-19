<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MentionUsersTest extends TestCase
{
    use DatabaseMigrations;

    // /** @test */
    // public function mentioned_users_in_a_reply_are_notified ()
    // {
    //     $yassine = create('App\User',['name' => ' Yassine']);

    //     $this->signIn($yassine);

    //     $sarra = create('App\User',['name'=>'sarra']);

    //     $thread = create('App\Thread');

    //     $reply = make('App\Reply',[
    //         'body' => '@sarra check this out @yassine',
    //     ]);

    //     $this->json('post',$thread->path(). '/replies', $reply->toArray());
        
    //     $this->assertCount(1,$sarra->notifications);
    // }
}
