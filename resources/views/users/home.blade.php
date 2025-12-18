@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="overflow-x-auto flex m-3">
        <div>
            {{-- {{ dd($user->stories) }} --}}
            @foreach ($users as $user)
                @if ($user->stories->count() > 1)
                    <a href="{{ route('story.create') }}" class="flex flex-col items-center">
                        @if (Auth::user()->avatar)
                            <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" class="rounded-circle"
                                style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                            <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                        @endif
                    </a>

                @else
                    <a href="" class="flex flex-col items-center">
                        @if (Auth::user()->avatar)
                            <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" class="rounded-circle"
                                style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                            <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                        @endif
                    </a>

                @endif

            @endforeach

        </div>
        <div class="">

            {{-- @foreach ($users as $user)
            <a href="" class="flex flex-col items-center"></a>
            <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}"
                class="w-20 h-20 rounded-full border-4 border-pink-500 object-cover">
            </a>
            @endforeach --}}
        </div>

    </div>

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
                                    <a href="{{ route('post.create') }}" class="text-decoration-none">Share your first photo</a>
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