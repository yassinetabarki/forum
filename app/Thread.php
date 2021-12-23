<?php

namespace App;

use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Model;
use function foo\func;

class Thread extends Model
{
    use RecordActivity;

    protected $guarded = [];
    protected $with=['creator','channel'];// to always include the creator in the query and you can't disable it

    protected $appends = ['isSubscribedTo'];
    
    protected static function boot()
    {
        parent::boot();
        // static::addGlobalScope('replyCount',function ($builder){
        //     $builder->withCount('replies');
        // });
        /** to eager load it*/
//        static::addGlobalScope('creator',function ($builder){
//            $builder->withCount('creator');
//        });
        static::deleting(function($thread){
//            $thread->replies->each->delete(); //higher order messaging for laravel collection
           $thread->replies->each(function ($reply){
               $reply->delete();
            });
        });
    }


    public function path(){

        return "/threads/{$this->channel->slug}/".$this->id;
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function addReply($reply)
    {
         $reply = $this->replies()->create($reply);

// prepare notifications for all subscribers
         //collection approch
             $this->subscriptions
            ->where('user_id','!=',$reply->user_id)
            ->each->notify($reply); //higher order 

        //  ->each(function ($sub) use($reply){

        //     $sub->user->notify(new ThreadWasUpdated($this,$reply));

        //  });
        
        // foreach ($this->subscriptions as $subscription) {
            
        //     if($subscription->user_id != $reply->user_id){
        //         $subscription->user->notify(new ThreadWasUpdated($this,$reply));
        //     }
            
        // }

         return $reply;

    }


    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function scopeFilter($query,$filters)
    {
        return $filters->apply($query);
    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id'=> $userId ?: auth()->id()
        ]);

        return $this;
    }
    

    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
        ->where('user_id', $userId ?: auth()->id())
        ->delete();
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function getIsSubscribedToAttribute(){
        return $this->subscriptions()
        ->where('user_id',auth()->id())
        ->exists();
    }
    
}
