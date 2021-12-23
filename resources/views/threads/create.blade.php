@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-8 col-md-offset-2 m-3">
                <div class="panel panel-default">
                    <div class="panel-heading">create Threads</div>
                    <div class="panel-body">
                        <form method="POST" action="/threads">
                            @csrf
                            <div class="form-group">
                                <label for="channel_id"> choose a channel</label>
                                <select class="form-control" name="channel_id" id="channel_id" required>
                                    <option value="">Choose one..</option>
                                    @foreach($channels as $channel)
                                        <option value="{{$channel->id}}" {{old('channel_id') ==$channel->id ? 'selected':'' }}>
                                            {{$channel->slug}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="title"></label>
                                <input name="title" id="title" type="text" class="form-control" placeholder="title" value="{{old('title')}}" required>
                            </div>
                            <div>
                                <label for="body"></label>
                                <textarea name="body" id="body" class="form-control" cols="30" rows="10" required>{{old('body')}}</textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" style="margin-top: 15px">Publish</button>
                            </div>
                                @if(count($errors))
                                    <ul class="alert alert-danger">
                                        @foreach($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
