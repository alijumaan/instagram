@extends('layouts.app')

@section('content')

    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    @forelse($posts as $post)
                    <div class="card mb-8 box-shadow">

                        <div class="card-header" style="background-color:  white;">
                            <div class="media text-muted pt-3" style="direction:  rtl;">
                                @if( $post->user->avatar == 'default.jpg')
                                    <img src="{{asset('images/'.$post->user->avatar)}}" style="width:10%;height:50px;">
                                @else
                                    <img src="{{asset('images/users/'. $post->user->avatar)}}" alt="" class="col-sm-2 rounded" style="margin-right: -3%; width: 50px;height: 50px;">
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
                        <a href="{{ route('posts.show', $post->id) }}"><img class="card-img-top" height="300px" src="{{ asset('images/posts/'. $post->image_path) }}" alt="Card image cap"></a>
                        <div class="card-body">
                            <p class="card-text" style="text-align: right;direction:  rtl;">{{ $post->body }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="row">
                                    <div class="btn-group" style="margin-top:  4px;">
{{--                                        <button class="btn btn-sm btn-outline-secondary" type="button" ><i class="fa fa-heart" style="margin-right:  10%;"></i><label id="count_id">{{ $count }}</label></button>--}}
                                        <button class="btn btn-sm btn-outline-secondary" id="btn_value_id" onclick="like_action()"> أعجبني </button>
                                        @auth
                                            @if( $post->user_id == auth()->user()->id )
                                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-outline-secondary" > تعديل </a>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                                <small class="text-muted">{{ $post->created_at->format('M d, Y') }}</small>
                            </div>
                        </div>
                    </div>
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
