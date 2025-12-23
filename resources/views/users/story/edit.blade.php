@extends('layouts.app')

@section('title', 'Edit Story')

@section('content')
<div class="container mt-4">

    <form action="{{ route('story.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="story-editor">

            {{-- 画像・動画表示 --}}
            @if($mediaType === 'image')
                <img src="{{ asset('storage/' . $mediaPath) }}" class="story-media">
            @elseif($mediaType === 'video')
                <video class="story-media" autoplay muted loop>
                    <source src="{{ asset('storage/' . $mediaPath) }}">
                </video>
            @endif

            {{-- テキスト入力 --}}
            <textarea
                class="story-text"
                name="text"
                placeholder="Type something..."
            ></textarea>
            @error('text')
                  <p class="text-danger small">{{ $message }}</p>
            @enderror

        </div>

        <input type="hidden" name="media_path" value="{{ $mediaPath }}">
        <input type="hidden" name="media_type" value="{{ $mediaType }}">
        @error('media')
            <div class="text-danger small">{{ $message }}</div>
        @enderror

        <button type="submit" class="btn btn-primary mt-3">Share</button>
    </form>

</div>
@endsection
