<reply :attributes="{{ $reply }}" inline-template v-cloak>
    <div id="reply-{{$reply->id}}" class="panel panel-default">
        <div class="panel-heading">
            <div class="level">
                <h5 class="flex">
                    <a href="/profile/{{$reply->owner->name}}">
                        {{$reply->owner->name}}
                    </a>said {{$reply->created_at->diffForHumans()}}
                </h5>
                <div>
                    <favorite :reply="{{$reply}}">

                    </favorite>
                   {{-- <form method="POST" action="/replies/{{$reply->id}}/favorites">
                       @csrf
                       <button type="submit" class="btn btn-default " {{$reply->isFavorited() ? 'disabled' : ''}}>
                           Favorite {{$reply->favorites->count()}}
                       </button>
                   </form> --}}
                </div>
            </div>
        </div>

        <div class="panel-body">
            <div v-if="editing" >
                <div class="forum-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>
                <button class="btn btn-xs btn-primary" @click="update">Update</button>
                <button class="btn btn-xs btn-link" @click="editing=false">Cancel</button>
            </div>
            <div v-else>
                <article>
                    <div class="body" v-text="body">{{$reply->body}}</div>
                </article>
            </div>
            <hr>
        </div> 
        @can('update',$reply)
            <div class="panel-footer level">
                <button class="btn btn-xs mr-1" @click="editing=true">Edit</button>
                <button class="btn btn-xs btn-danger mr-1" @click="destroy">Delete</button>
{{--                <form method="POST" action="/replies/{{$reply->id}}}">--}}
{{--                    @csrf--}}
{{--                    @method('DELETE')--}}
{{--                    <button type="submit" class="btn btn-danger btn-xs" >Delete</button>--}}
{{--                </form>--}}
            </div>
        @endcan
    </div>
</reply>
