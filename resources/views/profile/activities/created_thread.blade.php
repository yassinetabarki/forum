@component('profile.activities.activity')
    @slot('header')
        {{$profileUser->name}} created a 
        <a href="{{$activity->subject->path()}}">{{$activity->subject->title}}</a>
    @endslot

    @slot('body')
        <div class="body">{{$activity->subject->body}}</div>
    @endslot
@endcomponent

