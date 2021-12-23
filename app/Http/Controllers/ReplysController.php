<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReplysController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth')->except(['index']);
    }

    public function show()
    {

    }

    public function index($channelId ,Thread $thread)
    {
        return $thread->replies()->paginate(4);
    }


    /**
     * @param Thread $thread
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store($channelId,Thread $thread)
    {
        $this->validate(\request(),['body'=>'required']);
        $reply=$thread->addReply([
         'body'=> request('body'),
         'user_id'=> auth()->user()->id,
        ]);

        if(request()->expectsJson()){
            return $reply->load('owner');
        }
         return back()
             ->with('flash','Your reply has been left');
    }

    public function update(Reply $reply)
    {
        $this->authorize('update',$reply);
        $reply->update(\request(['body']));

    }
    public function destroy(Reply $reply)
    {
      $this->authorize('update',$reply);
        $reply->delete();

        if(request()->expectsJson())
        {
            return response(['status'=>'Reply delete']);
        }
        return back();
    }
}
