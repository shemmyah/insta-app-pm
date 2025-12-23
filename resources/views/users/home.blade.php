@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="flex gap-4 overflow-x-auto p-3">

        @if ($storyUsers->isNotEmpty())
            {{-- ストーリーあり → modalを開く --}}
            <div class="position-relative d-inline-block" data-bs-toggle="modal" data-bs-target="#storyModal"
                style="cursor: pointer;">

                @if (Auth::user()->avatar)
                    <img src="{{ Auth::user()->avatar }}" class="avatar-md rounded-circle">
                @else
                    <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                @endif

                <span class="position-absolute bottom-0 end-0 fs-4">+</span>
            </div>
        @else
            {{-- ストーリーなし →　createへ --}}
            <a href="{{ route('story.create', Auth::user()->id) }}" class="position-relative d-inline-block">
                @if (Auth::user()->avatar)
                <img src="{{ Auth::user()->avatar }}" class="avatar-md rounded-circle">
                @else
                <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                @endif

                <span class="position-absolute bottom-0 end-0 fs-4">+</span>
            </a>
            {{-- @if (Auth::user()->avatar)
                <a href="{{ route('story.edit') }}" class="position-relative d-inline-block">
                    <img src="{{ Auth::user()->avatar }}" class="avatar-md rounded-circle">
                </a>
            @else
                <a href="{{ route('story.edit') }}" class="position-relative d-inline-block">
                    <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                </a>
            @endif --}}
        @endif

    </div>

    @if ($storyUsers->isNotEmpty())
        <div class="modal fade" id="storyModal" tabindex="-1">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content bg-dark text-white">

                    {{-- 閉じる --}}
                    {{-- <button type="button" class="btn-close btn-close-white ms-auto m-3" data-bs-dismiss="modal"></button>
                    --}}

                    <div class="modal-body d-flex justify-content-center align-items-center">

                        <div class="story-editor position-relative">

                            {{-- 画像・動画 --}}
                            @if($mediaType === 'image')
                                <img src="{{ asset('storage/' . $mediaPath) }}" class="story-media">
                            @elseif($mediaType === 'video')
                                <video class="story-media" autoplay muted loop>
                                    <source src="{{ asset('storage/' . $mediaPath) }}">
                                </video>
                            @endif

                            {{-- テキスト --}}
                            @if(!empty($story->text))
                                <div class="story-overlay-text">
                                    {{ $story->text }}
                                </div>
                            @endif

                        </div>

                    </div>

                    <div class="modal-footer border-0 justify-content-center">
                        <button class="btn btn-danger">Delete</button>
                        <a href="/story/edit" class="btn btn-primary">Add</a>
                    </div>

                </div>
            </div>
        </div>
    @endif




    <main class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-9">
                    <div class="row gx-5">
                        <div class="col-8">
                            @forelse ($home_posts as $post)
                                <div class="card mb-4">
                                    {{-- title --}}
                                    @include('users.posts.contents.title')
                                    {{-- body --}}
                                    @include('users.posts.contents.body')
                                </div>
                            @empty
                                {{-- If the site doesn't have any post yet. --}}
                                <div class="text-center">
                                    <h2>Share Photos</h2>
                                    <p class="text-secondary">When you share photos, they'll appear on your profile.</p>
                                    <a href="{{ route('post.create') }}" class="text-decoration-none">Share your first
                                        photo</a>
                                </div>
                            @endforelse
                        </div>
                        <div class="col-4">
                            {{-- Profile Overview --}}
                            <div class="row align-items-center mb-5 bg-white shadow-sm rounded-3 py-3">
                                <div class="col-auto">
                                    <a href="{{ route('profile.show', Auth::user()->id) }}">
                                        @if (Auth::user()->avatar)
                                            <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}"
                                                class="rounded-circle avatar-md">
                                        @else
                                            <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                                        @endif
                                    </a>
                                </div>
                                <div class="col ps-0">
                                    <a href="{{ route('profile.show', Auth::user()->id) }}"
                                        class="text-decoration-none text-dark fw-bold">{{ Auth::user()->name }}</a>
                                    <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                            {{-- Suggestions --}}
                            @if ($suggested_users)
                                <div class="row">
                                    <div class="col-auto">
                                        <p class="fw-bold text-secondary">Suggestions For You</p>
                                    </div>
                                    <div class="col text-end">
                                        <a href="#" class="fw-bold text-dark text-decoration-none">See all</a>
                                    </div>
                                </div>

                                @foreach ($suggested_users as $user)
                                    <div class="row align-items-center mb-3">
                                        <div class="col-auto">
                                            <a href="{{ route('profile.show', $user->id) }}">
                                                @if ($user->avatar)
                                                    <img src="{{ $user->avatar }}" alt="{{ $user->name }}"
                                                        class="rounded-circle avatar-sm">
                                                @else
                                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                                @endif
                                            </a>
                                        </div>
                                        <div class="col ps-0 text-truncate">
                                            <a href="{{ route('profile.show', $user->id) }}"
                                                class="text-decoration-none text-dark fw-bold">{{ $user->name }}</a>
                                        </div>
                                        <div class="col-auto">
                                            <form action="{{ route('follow.store', $user->id) }}" method="post">
                                                @csrf
                                                <button type="submit"
                                                    class="border-0 bg-transparent p-0 text-primary btn-sm">Follow</button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection