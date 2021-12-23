<?php


namespace App;


use phpDocumentor\Reflection\Types\Static_;

trait RecordActivity
{
    protected static function bootRecordActivity()
    {
        if(auth()->guest()) return;
        foreach (Static::getRecordEvents() as $event){
            static ::$event(function ($model) use($event){
                $model->recordsActivity($event);
            });
        }
        static::deleting(function ($model){
            $model->activity()->delete();
        });

    }

    protected static function getRecordEvents()
    {
        return['created'];
    }
    protected function recordsActivity($event)
    {
        $this->activity()->create([
            'type'=> $this->getActivityType($event),
            'user_id'=> auth()->id(),
        ]);
//        Activity::create([
//            'type'=> $this->getActivityType($event),
//            'user_id'=> auth()->id(),
//            'subject_id'=> $this->id,
//            'subject_type'=> get_class($this)
//        ]);
    }

    public function activity()
    {
        return $this->morphMany('App\activity','subject');
    }
    protected function getActivityType($event)
    {
        $type=strtolower((new \ReflectionClass($this))->getShortName());
        return "{$event}_{$type}";
    }
}
