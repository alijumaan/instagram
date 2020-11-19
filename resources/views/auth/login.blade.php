@extends('layouts.app')

@section('content')
    <div class="py-5 text-center">
        <h2 class="">{{ __('frontend.Login') }}</h2>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('frontend.E-Mail Address') }}</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('frontend.Password') }}</label>

                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 ml-auto">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label pr-3" for="remember">
                                        {{ __('frontend.Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <hr class="mb-4">

                        <div class="form-group row">
                            <div class="col-md-8 ml-auto">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">{{ __('frontend.Login') }}</button>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('frontend.Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection