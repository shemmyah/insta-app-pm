@extends('layouts.app')

@section('title', 'Create Story')

@section('content')
<div class="container mt-4">

    <form action="{{ route('story.store', Auth::user()->id) }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="media" class="form-label fw-bold text-white">
                Image or Video
            </label>

            <input
                type="file"
                name="media"
                id="media"
                class="form-control"
                accept="image/*,video/*"
                required
            >

            <div class="form-text">
                Acceptable formats are image or video.<br>
                Maximum file size is 20MB.
            </div>

            @error('media')
                <div class="text-danger small">{{ $message }}</div>
            @enderror

 <div class="mt-3">
        <label for="storyText" class="form-label fw-bold text-white">Story Text</label>
        <textarea
            name="text"
            id="storyText"
            class="form-control rounded-3 shadow-sm"
            placeholder="Write something interesting..."
            rows="4"
            style="resize: none; font-size: 1rem; line-height: 1.5;"
        >{{ old('text') }}</textarea>
        @error('text')
            <p class="text-danger small mt-1">{{ $message }}</p>
        @enderror
            @error('text')
                  <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-warning px-5 m-3 ">
                Next
            </button>

        </div>
    </form>

</div>
@endsection
