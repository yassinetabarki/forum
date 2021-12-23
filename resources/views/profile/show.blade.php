@extends("layouts.app")
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="page-header">
                <h1>
                    {{$profileUser->name}}
                    <small>{{$profileUser->created_at->diffForHumans()}}</small>
                </h1>
            </div>
            @foreach($activities as $date=>$activity)
                @foreach($activity as $record)
                    <h3 class="page-he">{{$date}}</h3>ader
                        @if(view()->exists("profile.activities.{$record->type}"))
                            @include("profile.activities.{$record->type}",['activity'=>$record])
                        @endif
                    @endforeach

            @endforeach
{{--            {{$threads->links()}}--}}
        </div>
        </div>
    </div>
@endsection
