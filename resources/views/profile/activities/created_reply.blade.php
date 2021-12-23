@component('profile.activities.activity')
    @slot('header')
            {{$profileUser->name}} replied to 
            <a href="{{$activity->subject->thread->path()}}">{{$activity->subject->thread->title}}</a>
    @endslot
    @slot('body')
        <div class="body">{{$activity->subject->body}}</div>
    @endslot
@endcomponent
