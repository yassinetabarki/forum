<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Inspections\Spam;
use App\Thread;
use Gate;
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
     * store
     *
     * @param  mixed $channelId
     * @param  Thread $thread
     * @return void
     */
    public function store($channelId,Thread $thread)
    {
        try {
            if(Gate::denies('create',new Reply)){
                return response([
                    "info" => 'You are posting too many times',
                ],422);    
            }
            // $this->authorize('create',new Reply);
            request()->validate(['body' => 'required|spamFree']);
            $reply=$thread->addReply([
             'body'=> request('body'),
             'user_id'=> auth()->user()->id,
        ]);
        }catch(\Exception $e) {
            return response([
                
                "info" => 'Sorry your response could not be saved at this time .',
            ],422);
        }
            return $reply->load('owner');
        
    }
    
    /**
     * update
     *
     * @param  mixed $reply
     * @return void
     */
    public function update(Reply $reply)
    {
        $this->authorize('update',$reply);

       
       try{ 

        $this->validate(request(),['body' => 'required|spamFree']);
        $reply->update(\request(['body']));

       }catch(\Exception $e){
            return response([
                'info' => 'You cannot update with spam contents',
                ],422);
       }

        

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
        // $this->validate(request(),['body' => 'required|spamFree']);

        // resolve(Spam::class)->detect(request('body'));
    }
}
