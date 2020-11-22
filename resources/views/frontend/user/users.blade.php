@extends('layouts.app')

@section('content')
    <div class="album py-5 bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="my-3 p-3 bg-white rounded box-shadow" style="direction:  rtl;text-align:  right;">
                        <h6 class="border-bottom border-gray pb-2 mb-0">{{ __('frontend.Users') }}</h6>
                        @forelse ($users as $user)
                            <div class="media text-muted pt-3">
                                @if( $user->avatar == 'default.jpg')
                                    <img src="{{ asset('images/'. $user->avatar) }}" alt="" class="col-sm-2 mr-2 rounded" style="margin-right: -3%;width: 50px;height: 50px;">
                                @else
                                    <img src="{{ asset('images/users/'. $user->avatar) }}" alt="" class="col-sm-2 mr-2 rounded" style="margin-right: -3%;width: 50px;height: 50px;">
                                @endif
                                <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray" >
                                    <div class="d-flex justify-content-between align-items-center w-100">
                                        <strong class="text-gray-dark">{{$user->username}}</strong>
                                        <form method="POST" action="{{ route('followers.store') }}">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{$user->id}}">
                                            @csrf
                                            <input type="submit" class="btn btn-outline-success" value="{{ __('frontend.Send Request') }}">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>{{ __('frontend.No Users Found') }}</p>
                        @endforelse
                        <small class="d-block text-right mt-3">
                            <a href="#">{{ __('frontend.All Users') }}</a>
                        </small>
                    </div>
                </div>
                <!--
                </div>
                <div class="row"> -->
                <div class="col-md-6">
                    <div class="my-3 p-3 bg-white rounded box-shadow" style="direction:  rtl;text-align:  right;">
                        <h6 class="border-bottom border-gray pb-2 mb-0">{{ __('frontend.Sent Requests') }}</h6>
                        @forelse ($requests as $request)
                            <div class="media text-muted pt-3">
                                @if( $request->to_user->avatar == 'default.jpg')
                                    <img src="{{ asset('images/'. $request->to_user->avatar) }}" alt="" class="col-sm-2 mr-2 rounded" style="margin-right: -3%;width: 50px;height: 50px;">
                                @else
                                    <img src="{{asset('images/users/'.$request->to_user->avatar)}}" alt="" class="col-sm-2 mr-2 rounded" style="margin-right: -3%;width: 50px;height: 50px;">
                                @endif
                                <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray" >
                                    <div class="d-flex justify-content-between align-items-center w-100">
                                        <strong class="text-gray-dark">{{$request->to_user->username}}</strong>
                                        <form method="post" action="{{ route('followers.destroy', $request->id)}}">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" name="" class="btn btn-outline-warning" value="{{ __('frontend.Cancel Request') }}" >
                                        </form>
                                    </div>
                                    <span class="d-block">{{ __('frontend.Was Sent') }} {{ $request->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        @empty
                            <p>No Requests</p>
                        @endforelse
                        <small class="d-block text-right mt-3">
                            <a href="#">{{ __('frontend.All Updates') }}</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

