@extends('layouts.app')

@section('content')

    <div class="album py-5 bg-dark">
        <div class="container">
            <div class="row">
                @foreach ($posts as $post)
                    <div class="col-md-4 col-sm-6">
                        <div class="card mb-4 box-shadow">
                            <img class="card-img-top" src="{{asset('images/posts/'.$post->image_path)}}" alt="Card image cap" style="height: 250px">
                            <div class="card-body" >
                                <p class="card-text" style="text-align: right;direction:  rtl;">
                                    <small>@ {{$post->user->username}}</small><br>
                                    {{ $post->body }}
                                </p>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('posts.show', $post->id) }}">{{ __('frontend.Show') }}</a>
                                        <a class="btn btn-sm btn-outline-secondary" href="#"><i class="text-info fa fa-heart" style="margin-right: 3%;"></i>{{ $post->likes_count }}</a>
                                    </div>
                                    <small class="text-muted">{{ $post->created_at->format('Y-m-d') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {!! $posts->appends(request()->input())->links() !!}
        </div>
    </div>

@endsection

