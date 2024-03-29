<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use DatabaseMigrations;
    /**
    *  @test
     */
    public function user_could_check_last_recent_reply()
    {
        $user=create('App\User');

        $reply = create('App\Reply', [
            'user_id' => $user->id
        ]);
        
        $this->assertEquals($reply->id,$user->lastReply->id);

    }
}
