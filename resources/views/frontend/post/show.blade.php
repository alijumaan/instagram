@extends('layouts.app')

@section('content')
    <div class="album bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    <div class="card mb-8 box-shadow" style="width: 600px;">
                        <div class="card-header" style="background-color:  white;">
                            <div class="media text-muted pt-3" style="direction:  rtl;">
                                @if($post->user->avatar == 'default.jpg')
                                    <img src="{{asset('images/'. $post->user->avatar)}}" alt="" class="col-sm-2 rounded" style="margin-right: -3%; width: 70px">
                                @else
                                    <img src="{{asset('images/users/'. $post->user->avatar)}}" alt="" class="col-sm-2 rounded" style="margin-right: -3%; width: 70px">
                                @endif
                                <div class="media-body pb-3 mb-0" style="text-align: right;direction:  rtl;" >
                                    <p class="card-text" style="text-align: right;direction:  rtl;">{{ $post->user->username }}</p>
                                </div>
                                <div class="">
                                    @auth
                                        @if( $post->user_id == auth()->user()->id )
                                            <a class="btn btn-sm btn-outline-danger" href="javascript:void(0)" onclick="if (confirm('{{ __('frontend.R_u_sure') }}')) { document.getElementById('delete-{{ $post->id  }}').submit(); } else { return false; }" style="text-decoration: none">
                                                {{ __('frontend.Delete') }}
                                            </a>
                                            <form action="{{ route('posts.destroy', $post->id) }}" method="post" id="delete-{{ $post->id  }}" style="display: none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                                @can('update', $post)
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="post" id="ajax_unlike">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-secondary" >{{ __('frontend.Delete') }}</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                        <img class="card-img-top" src="{{ asset('images/posts/'. $post->image_path) }}" alt="Card image cap" style="height: 600px;">
                        <div class="card-body">
                            <p class="card-text" style="text-align: right;direction:  rtl;">{{ $post->body }}</p>
                            <div class="d-flex justify-content-between align-items-center">

                                <div class="row">
                                    <div class="btn-group" style="margin-top:  4px;">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" >
                                            <i class="fa fa-heart" style="margin-right: 10%;"></i>
                                            <label id="count_id">{{ $count }}</label>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary" id="btn_value_id" onclick="like_action()" type="submit">
                                            {{ __('frontend.Like') }}
                                        </button>
                                    </div>
                                </div>

                                <small class="text-muted">{{ $post->created_at->format('M d, Y') }}</small>
                            </div>
                        </div>

                        <div class="card-footer" style="direction:  rtl;text-align:  right;">
                            <div class="media text-muted pt-3">
                                <img src="{{asset('images/users/'.auth()->user()->avatar)}}" alt="" class="col-sm-2 rounded" style="margin-top:  1%;margin-right: -3%; width: 50px;height: 50px;">
                                <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray" >
                                    <div class="d-flex justify-content-between align-items-center w-100">
                                        <strong class="text-gray-dark">{{auth()->user()->name}}</strong>
                                    </div>
                                    <form action="{{ route('comments.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <input type="text" name="comment" class="form-control" placeholder="{{ __('frontend.Add Comment') }}" style="width:  100%;">
                                                @error('comment')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                            <div class="col-md-2" style="margin-top: 4px;">
                                                <input type="submit" class="btn btn-sm btn-outline-secondary" name="send" value="{{ __('frontend.Comment') }}">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @foreach ( $post->comments as $comment)
                                <div class="media text-muted pt-3">
                                    <img src="{{asset('images/users/'.$comment->user->avatar)}}" alt="" class="col-sm-2 rounded" style="margin-top:  1%;margin-right: -3%; width: 50px;height: 50px;">
                                    <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray" >
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <strong class="text-gray-dark">{{$comment->user->name}}</strong><br>
                                            @if($comment->user->id==auth()->user()->id)
                                                <form action="{{ route('comments.destroy', $comment->id) }}" method="post">
                                                    {{ csrf_field() }}
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <input type="submit" class="btn btn-outline-danger" value="{{ __('frontend.Delete') }}">
                                                </form>
                                            @endif
                                        </div>
                                        <span class="d-block">{{$comment->comment}}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script>
        let like = "أعجبني";
        let unlike = "إلغاء الإعجاب";
        let token = '{{ csrf_token() }}';
        let post_id = "{{ $post['id'] }}";
        let like_id = 0;

        @if( sizeof( $userLike) == 1 )
            like_id = "{{ $userLike[0]->id }}";
        $('#btn_value_id').html(unlike);
        @endif

        function like_action(){

            if( like_id == 0 ){
                $.ajax({
                    type: "POST",
                    url: "{{ url('likes') }}",
                    data: {post_id: post_id, _token: token},
                    success: function( msg ) {
                        $('#count_id').html(msg.count);
                        $('#btn_value_id').html(unlike);
                        like_id = msg.id;
                    }
                });
            }
            else {
                $.ajax({
                    type: "POST",
                    url: "{{ url('likes') }}/" + post_id,
                    data: { post_id: post_id, _token: token, _method:"DELETE" },
                    success: function( msg ) {
                        $('#count_id').html(msg.count);
                        $('#btn_value_id').html(like);
                        like_id = 0;
                    }
                });
            }
        }

    </script>

@endsection
