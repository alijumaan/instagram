@extends('layouts.app')

@section('content')

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="filename">{{ __('frontend.Image') }}</label>
            <input type="file" class="form-control" name="filename">
            @error('filename')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="body">{{ __('frontend.Content') }}</label>
            <textarea class="form-control" name="body" id="body" cols="30" rows="5"></textarea>
            @error('body')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <button class="btn btn-primary btn-lg btn-block">{{ __('frontend.Publish') }}</button>
        </div>

    </form>

@endsection





