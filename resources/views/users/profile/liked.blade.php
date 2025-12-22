@extends('layouts.app')

@section('title', $user->name . ' • Liked posts')

@section('content')
<div class="profile-page">

    @include('users.profile.header')

    {{-- TABS --}}
    <div class="profile-tabs d-flex justify-content-center mt-4">
        <a href="{{ route('profile.show', $user->id) }}" class="tab-item text-decoration-none">
            <i class="fa-solid fa-table-cells me-1"></i> POSTS
        </a>

        <a href="{{ route('profile.liked', $user->id) }}" class="tab-item text-decoration-none active">
            <i class="fa-regular fa-heart me-1"></i> LIKED
        </a>

        <div class="tab-item text-decoration-none">
            <i class="fa-regular fa-id-badge me-1"></i> TAGGED
        </div>
    </div>

    {{-- LIKED POSTS GRID --}}
    <div class="profile-posts mt-3">
        @if ($likedPosts->isNotEmpty())
            <div class="row g-1 g-md-3">
                @foreach ($likedPosts as $post)
                    <div class="col-4">
                        <a href="{{ route('post.show', $post->id) }}" class="grid-link">
                            <div class="grid-square">
                                <img src="{{ $post->image }}" class="profile-grid-img">

                                <div class="grid-overlay">
                                    <span>
                                        <i class="fa-solid fa-heart"></i>
                                        {{ $post->likes->count() }}
                                    </span>
                                    <span>
                                        <i class="fa-solid fa-comment"></i>
                                        {{ $post->comments->count() }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center mt-5 text-secondary">
                <i class="fa-regular fa-heart fs-1 mb-2"></i>
                <p>No liked posts yet</p>
            </div>
        @endif
    </div>

</div>
@endsection
