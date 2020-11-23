@extends('layouts.app')

@section('content')

    <div class="album py-5 bg-dark">
        <div class="container">
            <div class="row" style="direction:  rtl;text-align:  right;">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <h4 class="mb-3 center text-white">{{ __('frontend.Personal Information') }}</h4>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            @if( $user->avatar == 'default.jpg'  )
                                <img alt="{{ $user->username }}" src="{{ asset('images/'.$user->avatar) }}" style="margin-right: -3%;max-width: 70px;max-height: 150px;">
                            @else
                                <img alt="{{ $user->username }}" src="{{ asset('images/users/'.$user->avatar) }}" style="margin-right: -3%;max-width: 70px;max-height: 150px;">
                            @endif
                        </div>
                        <div class="col-md-6 mb-5 text-white">
                            <h2 id="name">{{ $user->first_name }} {{ $user->last_name }}</h2>
                            <h3 id="birth_date">{{ $user->birth_date }}</h3>
                            <button class="btn btn-sm btn-outline-secondary mb-2" type="button" style="width:  60%;"><i class="fa fa-bullhorn"></i> |
                                {{ __('frontend.He Has Published') }} {{ $posts_counts }} {{ __('frontend.Published') }}!</button>
                            <br>
                            <button class="btn btn-sm btn-outline-secondary mb-2" type="button" style="width:  60%;"><i class="fa fa-heart"></i> | حصد {{ $likes_counts }} {{ __('frontend.Likes') }}</button>
                        </div>
                        <div class="col-md-3 mb-3">
                            @if( isset($is_follower[0]) && $is_follower[0]->accepted == 1 )
                                <button class="btn btn-sm btn-outline-info" type="button" style="width:  100%;" onclick="location.href='{{ route('user.friend.posts', $user->id) }}';"><i class="fa fa-eye"></i> {{ __('frontend.Personal Page') }}</button>
                            @elseif( isset($is_follower[0]) && $is_follower[0]->accepted == 0 )
                                <button class="btn btn-sm btn-outline-warning" type="button" style="width:  100%;"><i class="fa fa-paper-plane"></i>{{ __('frontend.Request Was Sent') }}</button>
                            @else
                                <form method="POST" action="{{ route('followers.store') }}">
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-success" style="width:  100%;"><i class="fa fa-paper-plane"></i>{{ __('frontend.Send Request') }}</button>
                                </form>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($posts as $post)
                            <div class="col-md-6 col-sm-12 col-xl-4 col-lg-4 col-xl-3">
                                <div class="card mb-4 box-shadow">
                                    <img class="card-img-top" src="{{ asset('images/posts/'.$post->image_path) }}" alt="Card image cap" style="height: 166px">
                                    <div class="card-body" style="height:  50px;">
                                        <p class="card-text" style="text-align: right;direction:  rtl;">{{ Str::limit($post->body, 30, ' (...)') }}</p>
                                        <br>
                                    </div>
                                    <div class="card-footer">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">{{ $post->created_at->format('Y-m-d') }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

