@component('profile.activities.activity')
    @slot('header')
        <a href="{{$activity->subject->favorited->path()}}">
            {{$profileUser->name}} favorited
        </a>
{{--        <a href="{{$activity->subject->thread->path()}}">{{$activity->subject->thread->title}}</a>--}}
    @endslot
    @slot('body')
        <div class="body">{{$activity->subject->favorited->body}}</div>
    @endslot
@endcomponent
