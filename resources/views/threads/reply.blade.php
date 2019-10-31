<div class="panel panel-default">
    <div class="panel-heading">
        <div class="level">
            <h5 class="flex">
                <a href="#">
                    {{$reply->owner->name}}
                </a>said {{$reply->created_at->diffForHumans()}}
            </h5>
            <div>
                <form method="POST" action="/replies/{{$reply->id}}/favorites">
                    @csrf
                    <button type="submit" class="btn btn-default " {{$reply->isFavorited() ? 'disabled' : ''}}>
                        Favorite {{$reply->favorites->count()}}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <article>
            <div class="body">{{$reply->body}}</div>
        </article>
        <hr>
    </div>
</div>
