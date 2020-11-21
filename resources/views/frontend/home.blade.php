@extends('layouts.app')

@section('content')

    <div class="album bg-light">
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-md-6">
                    @forelse($posts as $post)
                    <div class="card mb-8 box-shadow" style="width: 600px;">

                        <div class="card-header" style="background-color:  white;">
                            <div class="media text-muted pt-3" style="direction:  rtl;">
                                @if( $post->user->avatar == 'default.jpg')
                                    <img src="{{asset('images/'. $post->user->avatar)}}" alt="" class="col-sm-2 rounded" style="margin-right: -3%; height: 50px">
                                @else
                                    <img src="{{asset('images/users/'. $post->user->avatar)}}" alt="" class="col-sm-2 rounded" style="margin-right: -3%; height: 50px">
                                @endif
                                <div class="media-body mb-0" style="text-align: right;direction:  rtl;" >
                                    <p class="card-text" style="text-align: right;direction:  rtl;">{{ $post->user->username }}</p>
                                </div>
                                @can('update', $post)
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="post" id="ajax_unlike">
                                        {{ csrf_field() }}
                                        <input name="_method" type="hidden" value="DELETE">
                                        <button class="btn btn-sm btn-outline-secondary" >حذف</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                        <a href="{{ route('posts.show', $post->id) }}"><img class="card-img-top" height="600px" src="{{ asset('images/posts/'. $post->image_path) }}" alt="Card image cap"></a>
                        <div class="card-body">
                            <p class="card-text" style="text-align: right;direction:  rtl;">{{ $post->body }}</p>
                            <div class="d-flex justify-content-between align-items-center">

                                <form action="{{ route('likes.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <div class="row">
                                        <div class="btn-group" style="margin-top:  4px;">
{{--                                            <button class="btn btn-sm btn-outline-secondary" type="button" ><i class="fa fa-heart" style="margin-right:  10%;"></i><label id="count_id">{{ $post->count() }}</label></button>--}}
{{--                                            <button class="btn btn-sm btn-outline-secondary" id="btn_value_id" onclick="like_action()" type="submit"> أعجبني </button>--}}
                                            @auth
                                                @if( $post->user_id == auth()->user()->id )
                                                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-outline-secondary" > تعديل </a>
                                                @endif
                                            @endauth
                                        </div>
                                    </div>
                                </form>

                                <small class="text-muted">{{ $post->created_at->format('M d, Y') }}</small>
                            </div>
                        </div>
                    </div>
                        <br>
                    @empty
                        <p>No Posts found.</p>
                    @endforelse
                        <div class="pt-3">
                            {!! $posts->appends(request()->input())->links() !!}
                        </div>
                </div>
            </div>
        </div>
    </div>

@endsection

