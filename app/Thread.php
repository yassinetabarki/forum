<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use function foo\func;

class Thread extends Model
{
    use RecordActivity;

    protected $guarded = [];
    protected $with=['creator','channel'];// to always include the creator in the query and you can't disable it

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
         return $this->replies()->create($reply);
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
        $this->subscription()->create([
            'user_id'=> $userId ?: auth()->id()
        ]);
    }
    

    
    public function unsubscribe($userId = null)
    {
        $this->subscription()
        ->where('user_id', $userId ?: auth()->id())
        ->delete();
    }

    public function subscription()

    {
        return $this->hasMany(ThreadSubscription::class);
    }
    
}
