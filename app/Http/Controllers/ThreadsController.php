<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Filters\ThreadFilters;
use App\Inspections\Spam;
use App\Thread;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ThreadsController extends Controller
{
    /**
     * ThreadsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index','show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Channel $channel
     * @param ThreadFilters $filters
     * @return void
     */
    public function index(Channel $channel,ThreadFilters $filters)
    {

        $threads = $this->getThreads($channel, $filters);
        if(request()->wantsJson()){
            // return $threads;
            return response()->json($threads);
        }
        return view('threads.index', compact('threads'));
        // return response()->json($threads);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request,Spam $spam)
    {
        $this->validate($request,[
            'title'=>'required|spamFree',
            'body'=>'required|spamFree',
            'channel_id'=>'required|exists:channels,id'
        ]);

        // $spam->detect(request('body'));
        
        $thread=Thread::create([
            'user_id'=>auth()->id(),
            'channel_id'=>request('channel_id'),
            'title'=> $request->title,
            'body'=> $request->body
        ]);
        return redirect($thread->path())
            ->with('flash','Your Thread was created');
    }

    /**
     * Display the specified resource.
     *
     * @param $channel
     * @param  \App\Thread $thread
     * @return Thread
     */
    public function show($channel,Thread $thread)
    {
        $key = sprintf("users.%s.visits.%s" ,auth()->id(),$thread->id);

        cache()->forever($key,Carbon::now());

        return view('threads.show',compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Channel $channel,Thread $thread)
    {
        $this->authorize('update',$thread);
        $thread->delete();
        if(\request()->wantsJson()){
            //            $thread->replies()->delete(); // we can use model event check thread model
            return response([],204);
        }
        return redirect('/threads');
    }

    /**
     * @param Channel $channel
     * @param ThreadFilters $filters
     * @return mixed
     */
    protected function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::latest()->filter($filters);

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

        $threads = $threads->get();
        return $threads;
    }

}
