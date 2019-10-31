<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReplysController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function show()
    {

    }

    /**
     * @param Thread $thread
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store($channelId,Thread $thread)
    {
        $this->validate(\request(),['body'=>'required']);
        $thread->addReply([
         'body'=> request('body'),
         'user_id'=> auth()->user()->id,
        ]);
         return back();
    }
}
