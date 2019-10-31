@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><a href="#">{{$thread->creator->name}}</a> Posted:
                        {{$thread->title}}</div>
                    <div class="panel-body">
                            <article>
                                <div class="body">{{$thread->body}}</div>
                            </article>
                        <hr>
                    </div>
                </div>
                    @foreach($replies as $reply)
                        @include('threads.reply')
                    @endforeach
                    {{$replies->links()}}
                    @if(auth()->check())
                    <form method="POST" action="{{$thread->path().'/replies'}}" >
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="body"></label>
                            <textarea name="body" id="body" class="form-control" placeholder="have  something to say" rows="5">
                            </textarea>
                            <button type="submit" class="btn btn-group">post</button>
                        </div>
                    </form>
                    @else
                    <p class="text-center">
                        Please <a href="{{route('login')}}"> sign in</a>
                        to paticiptate in the discussion</p>
                    @endif
            </div>
            <div class="col-md-5">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>
                            This thread was create at {{$thread->created_at->diffForHumans()}}
                            by <a href="#">{{$thread->creator->name}}</a> and has
                            {{$thread->replies_count}} {{str_plural('comment',$thread->replies_count)}}.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
