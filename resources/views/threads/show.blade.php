@extends('layouts.app')

@section('content')
    <thread-view  :initial-replies-count="{{$thread->replies_count}}" inline-template>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="level">
                                <span class="flex">
                            <a href="/profile/{{$thread->creator->name}}">{{$thread->creator->name}}</a> Posted:
                            <a href="{{$thread->path()}}">{{$thread->title}}</a>
                                </span>
                                @can('update',$thread)
                                <form action="{{$thread->path()}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link alert-danger">Delete Thread</button>
                                </form>
                                    @endcan
                            </div>
                        </div>
                        <div class="panel-body">
                            <article>
                                <div class="body">{{$thread->body}}</div>
                            </article>
                            <hr>
                        </div>
                    </div>
                    <replies {{-- :data= "{{$thread->replies}}" --}} @added="repliesCount++" @removed="repliesCount--"></replies>
        
                </div>
                        {{-- {{$replies->links()}} --}}
                        
                        {{-- @if(auth()->check())
                        <form method="POST" action="{{$thread->path().'/replies'}}" >
                            @csrf
                            <div class="form-group">
                                <label for="body"></label>
                                <textarea name="body" id="body" class="form-control" placeholder="have  something to say ?" rows="5">
                                </textarea>
                                <button type="submit" class="btn btn-group">post</button>
                            </div>
                        </form>
                        @else
                        <p class="text-center">
                            Please <a href="{{route('login')}}"> sign in</a>
                            to paticiptate in the discussion</p>
                        @endif --}}
                <div class="col-md-5">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <p>
                                This thread was create at {{$thread->created_at->diffForHumans()}}
                                by <a href="/profile/{{$thread->creator->name}}">{{$thread->creator->name}}</a> and has
                                <span v-text="repliesCount"></span>{{-- {{$thread->replies_count}} --}} {{str_plural('comment',$thread->replies_count)}}.
                            </p>

                            <subscribe-button :active="{{ json_encode($thread->isSubscribedTo)}}" > </subscribe-button>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
@endsection

