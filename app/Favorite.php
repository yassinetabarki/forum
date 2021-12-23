<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use RecordActivity;

    public function favorited()
    {

        return $this->morphTo();

        
    }
    protected $guarded=[];
}
