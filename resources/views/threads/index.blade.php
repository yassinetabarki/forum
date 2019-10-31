@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-8 col-md-offset-2 m-3">
                <div class="panel panel-default">
                    <div class="panel-heading">Threads view</div>

                    <div class="panel-body">
                       @foreach($threads as $thread)
                           <article>
                               <div class="level">
                                   <h4 class="flex">
                                       <a href="{{$thread->path()}}"><h4>{{$thread->title}}</h4></a>
                                   </h4>
                                   <strong>{{$thread->replies_count}} {{str_plural('reply',$thread->replies_count)}}</strong>
                               </div>
                               <div class="body">{{$thread->body}}</div>
                             </article>
                           <hr>
                           @endforeach
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
