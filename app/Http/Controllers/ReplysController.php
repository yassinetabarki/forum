<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Inspections\Spam;
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
     */
    public function store($channelId,Thread $thread)
    {
        try{
        $this->validateReply();
        
        $reply=$thread->addReply([
         'body'=> request('body'),
         'user_id'=> auth()->user()->id,
        ]);
        }catch(\Exception $e) {
            return response('Sorry your response could not be saved at this time .',422);
        }
        

        if(request()->expectsJson()){
            return $reply->load('owner');
        }
         return back()
             ->with('flash','Your reply has been left');
    }

    public function update(Reply $reply,Spam $spam)
    {
        $this->authorize('update',$reply);

       

        $reply->update(\request(['body']));

    }
    public function destroy(Reply $reply)
    {
        $this->authorize('update',$reply);
        $reply->delete();

        if(request()->expectsJson()){
            return response(['status'=>'Reply delete']);
        }

        return back();
    }

    public function validateReply()
    {
        $this->validate(request(),['body' => 'required']);

        resolve(Spam::class)->detect(request('body'));
    }
}
