<?php


namespace App;
use Illuminate\Database\Eloquent\Model;

trait Favoritable
{
    public function favorites()
    {
        return $this->morphMany(Favorite::class,'favorited');
    }

    public function favorite()
    {
        if(! $this->favorites()->where('user_id', auth()->id())->exists())
            return $this->favorites()->create(['user_id'=> auth()->id()]);
    }

    public function unfavorite()
    {
        $attributes = ['user_id' => auth()->id()];

        $this->favorites()->where($attributes)->get()->each->delete();
    }
    public function isFavorited()
    {
        return !! $this->favorites->where('user_id',auth()->id())->count();
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }
    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

}
