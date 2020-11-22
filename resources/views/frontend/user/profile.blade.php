@extends('layouts.app')
@section('style')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
@endsection
@section('content')

    <div class="py-5 text-center">
        <h2 class="mb-3 center text-white">{{ __('frontend.Personal Information') }}</h2>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <form method="post" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-white" for="first_name">{{ __('frontend.First Name') }}</label>
                        <input type="text" id="first_name" placeholder="" value="{{$user->first_name}}" class="form-control text-white bg-dark @error('first_name') is-invalid @enderror" name="first_name" autofocus>
                        @error('first_name')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="text-white" for="last_name">{{ __('frontend.Last Name') }}</label>
                        <input type="text" id="last_name" placeholder="" value="{{$user->last_name}}" class="form-control text-white bg-dark @error('last_name') is-invalid @enderror" name="last_name" autofocus>
                        @error('last_name')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="text-white" for="birth_date">{{ __('frontend.Birth Date') }}</label>
                        <input id="datepicker" width="100%" value="{{$user->birth_date}}" class="form-control text-white bg-dark @error('birth_date') is-invalid @enderror" name="birth_date" autofocus/>
                        @error('birth_date')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-6">
                        @if( $user->avatar == 'default.jpg')
                            <img src="{{asset('images/'.$user->avatar)}}" style="width:40%;height:150px;">
                        @else
                            <img src="{{asset('images/users/'.$user->avatar)}}" style="width: 70%;height:  250px;">
                        @endif
                    </div>
                    <div class="col-md-6 mb-6">
                        <label class="text-white" for="filename">{{ __('frontend.Image') }}</label>
                        <input type="file" id="filename" name="avatar" class="pt-3 text-white bg-dark @error('filename') is-invalid @enderror">
                        @error('filename')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                </div>
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">{{ __('frontend.Update') }}</button>
            </form>
        </div>
    </div>

@endsection

@section('script')

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'yyyy-mm-dd'
        });
    </script>
    <script>window.jQuery || document.write('<script src="{{ asset('assets/js/vendor/jquery-slim.min.js') }}"><script>')</script>
    <script src="{{ asset('assets/js/vendor/popper.min.js') }}"></script>
    <script src="{{ asset('dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/holder.min.js') }}"></script>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';

            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                let forms = document.getElementsByClassName('needs-validation');

                // Loop over them and prevent submission
                let validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>

@endsection
