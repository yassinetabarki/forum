@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row ">
                <div class="col-md-8 col-md-offset-2 m-3">
                    @forelse($threads as $thread)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="level">
                                <h4 class="flex">
                                    <a href="{{$thread->path()}}">
                                        @if ($thread->hasUpdatesFor(auth()->user()))
                                            <strong >
                                                {{$thread->title}}
                                            </strong>
                                        @else
                                            <h4 class="text-danger">
                                                {{$thread->title}}
                                            </h4>
                                        @endif
                                       
                                    </a>
                                </h4>
                                <a href="{{$thread->path()}}">{{$thread->replies_count}} {{str_plural('reply',$thread->replies_count)}}</a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="body">{{$thread->body}}</div>
                        </div>
                    </div>
                    @empty
                        <p>There is not record available at the time being..</p>
                    @endforelse
                </div>
        </div>
    </div>
@endsection
