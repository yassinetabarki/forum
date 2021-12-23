<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\DatabaseNotification;
use Notification;

class NotificationsTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase ;

    public function setUp()
    {
        parent::setUp();
        $this->signIn();
    }
    /** @test */
    public function a_user_can_fetch_their_unread_notifications(){
        

        create(DatabaseNotification::class);
        $user= auth()->user();

        $response= $this->getJson("/profile/{$user->name}/notifications")->json();  

        $this->assertCount(1,$response);
    }
    

    /** @test */
    public function a_notification_is_prepared_when_subscribed_thread_receives_a_new_reply()
    { 
       
        //Given we have a thread
        $thread = create("App\Thread")->subscribe();


        $this->assertCount(0,auth()->user()->notifications);
     

     
        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'some reply here'
        ]);

        // //  A notification should be prepared for the user 

        $this->assertCount(0,auth()->user()->fresh()->notifications);

        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'some reply here'
        ]);

        $this->assertCount(1,auth()->user()->fresh()->notifications);
    }

    /** @test */
    public function a_user_can_clear_there_notifications ()
    {
     
        
      
        create(DatabaseNotification::class);

        $this->assertCount(1,auth()->user()->unreadNotifications);

        $notificationId = auth()->user()->unreadNotifications->first()->id;

        $this->delete("/profile/".auth()->user()->name."/notifications/{$notificationId}");

        $this->assertCount(0,auth()->user()->fresh()->unreadNotifications);
    }
}
