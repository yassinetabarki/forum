<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class ThreadSubscriptionController extends Controller
{
    public function store($channelId , Thread $thread) {
        
        $thread->subscribe();
    }

    public function destory( $channelId, Thread $thread)
    {
        $thread->unsubscribe();
        
    }
}
