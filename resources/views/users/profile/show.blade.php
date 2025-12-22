@extends('layouts.app')

@section('title', $user->name)

@section('content')
    <div class="profile-page">

        @include('users.profile.header')

        {{-- TABS --}}
        <div class="profile-tabs d-flex justify-content-center mt-4">
            <a href="{{ route('profile.show', $user->id) }}"
                class="tab-item text-decoration-none {{ request()->routeIs('profile.show') ? 'active' : '' }}">
                <i class="fa-solid fa-table-cells me-1"></i> POSTS
            </a>

            <a href="{{ route('profile.liked', $user->id) }}"
                class="tab-item text-decoration-none {{ request()->routeIs('profile.liked') ? 'active' : '' }}">
                <i class="fa-regular fa-heart me-1"></i> LIKED
            </a>

            <div class="tab-item text-decoration-none">
                <i class="fa-regular fa-id-badge me-1"></i> TAGGED
            </div>
        </div>


        {{-- POSTS GRID --}}
        <div class="profile-posts mt-3">
            @if ($user->posts->isNotEmpty())
                <div class="row g-1 g-md-3">
                    @foreach ($user->posts as $post)
                        <div class="col-4">
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
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center mt-5 text-secondary">
                    <i class="fa-solid fa-camera fs-1 mb-2"></i>
                    <p>No posts yet</p>
                </div>
            @endif
        </div>

    </div>
@endsection
