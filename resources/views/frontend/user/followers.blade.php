@extends('layouts.app')

@section('content')

    <div class="album py-5 bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="my-3 p-3 bg-white rounded box-shadow" style="direction:  rtl;text-align:  right;">
                        <h6 class="border-bottom border-gray pb-2 mb-0">طلبات المتابعة</h6>
                        @foreach ($follow_requests as $request)
                            <div class="media text-muted pt-3">
                                @if( $request->from_user->avatar == 'default.jpg')
                                    <img src="{{ asset('images/'.$request->from_user->avatar) }}" alt="" class="col-sm-2 mr-2 rounded" style="margin-right: -3%;width: 50px;height: 50px;">
                                @else
                                    <img src="{{ asset('images/users/'.$request->from_user->avatar) }}" alt="" class="col-sm-2 mr-2 rounded" style="margin-right: -3%;width: 50px;height: 50px;">
                                @endif
                                <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray" >
                                    <div class="d-flex justify-content-between align-items-center w-100">
                                        <strong class="text-gray-dark">{{$request->from_user->username}}</strong>
                                        <form method="post" action="{{ route('followers.destroy', $request->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" name="" class="btn btn-outline-warning" value="{{ __('frontend.Ignore') }}" style="margin-right: 76%;">
                                        </form>
                                        <form method="post" action="{{ route('followers.update', $request->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="submit" class="btn btn-outline-success" value="{{ __('frontend.Accept') }}">
                                        </form>
                                    </div>
                                    <span class="d-block">تاريخ الطلب {{ $request->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        @endforeach
                        <small class="d-block text-right mt-3">
                            <a href="#">جميع الطلبات</a>
                        </small>
                    </div>
                </div>
                <!--
                </div>
                <div class="row"> -->
                <div class="col-md-6">
                    <div class="my-3 p-3 bg-white rounded box-shadow" style="direction:  rtl;text-align:  right;">
                        <h6 class="border-bottom border-gray pb-2 mb-0">{{ __('frontend.Friends') }}</h6>
                        @foreach ($followers as $follower)

                            @php
                                $user = $follower->from_user->id == auth()->user()->id ? $follower->to_user : $follower->from_user;
                            @endphp
                            <div class="media text-muted pt-3">
                                @if( $user->avatar == 'default.jpg')
                                    <img src="{{ asset('images/'.$user->avatar) }}" alt="" class="col-sm-2 mr-2 rounded" style="margin-right: -3%;width: 50px;height: 50px;">
                                @else
                                    <img src="{{asset('images/users/'.$user->avatar)}}" alt="" class="col-sm-2 mr-2 rounded" style="margin-right: -3%;width: 50px;height: 50px;">
                                @endif

                                <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                    <div class="d-flex justify-content-between align-items-center w-100">
                                        <a href="{{ url('users/'.$user->id.'/posts') }}"><strong class="text-dark">{{ $user->username}}</strong></a>
                                        <form method="post" action="{{ route('followers.destroy', $follower->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" class="btn btn-outline-danger" value="{{ $follower->from_user->id == auth()->user()->id ? __('frontend.Unfollow') : __('frontend.Refuse Following') }}">
                                        </form>
                                    </div>
                                    <span class="d-block">{{ $follower->from_user->id == auth()->user()->id ? __('frontend.Is Follow Since') : __('frontend.Is Following Since') }} {{ $follower->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        @endforeach
                        <small class="d-block text-right mt-3">
                            <a href="#">جميع التحديثات</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

