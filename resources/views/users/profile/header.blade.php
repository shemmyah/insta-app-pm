<div class="profile-header">

    <div class="row mb-3">
        <div class="col-4 text-center">
            <div class="avatar-container">
                @if ($user->avatar)
                    <img src="{{ $user->avatar }}" class="profile-avatar">
                @else
                    <i class="fa-solid fa-circle-user profile-avatar-icon"></i>
                @endif

                {{-- NOTE BUBBLE --}}
                {{-- NOTE BUBBLE --}}
                @if (Auth::check() && Auth::id() === $user->id)
                    <div class="note-bubble" data-bs-toggle="modal" data-bs-target="#noteModal">
                        {{ $user->note->content ?? 'Add a note...' }}
                    </div>
                @elseif($user->note)
                    <div class="note-bubble" data-bs-toggle="modal" data-bs-target="#noteModal">
                        {{ $user->note->content }}
                    </div>
                @endif

            </div>
        </div>

        <div class="col-8">
            <h5 class="fw-bold mb-1 text-white">{{ $user->name }}</h5>
            <p class="text-secondary mb-2">{{ '@' . $user->name }}</p>

            <div class="d-flex gap-3 mb-2">
                <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-white">
                    <strong>{{ $user->posts->count() }}</strong> {{ $user->posts->count() == 1 ? 'post' : 'posts' }}
                </a>
                <a href="{{ route('profile.followers', $user->id) }}" class="text-decoration-none text-white btn-link" data-bs-toggle="modal" data-bs-target="#followersModal">
                    <strong>{{ $user->followers->count() }}</strong>
                    {{ $user->followers->count() == 1 ? 'follower' : 'followers' }}
                </a>
                <a href="{{ route('profile.following', $user->id) }}" class="text-decoration-none text-white btn-link" data-bs-toggle="modal" data-bs-target="#followingModal">
                    <strong>{{ $user->following->count() }}</strong> following
                </a>
            </div>

            <p class="profile-bio">{{ $user->introduction }}</p>
        </div>
    </div>

    <div class="row gx-2">
        <div class="col-6">
            <a href="{{ route('profile.edit') }}" class="btn btn-profile-action w-100">Edit profile</a>
        </div>
        <div class="col-6">
            <button class="btn btn-profile-action w-100">View archive</button>
        </div>
    </div>

</div>

{{-- NOTE MODAL --}}
<div class="modal fade" id="noteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content ig-note-modal">

            <div class="modal-header border-0" style="background-color: #121212; color: #fff;">
                <h6 class="fw-bold">
                    @if (Auth::check() && Auth::id() === $user->id)
                        @if ($user->note)
                            Your Note
                        @else
                            What's on your mind?
                        @endif
                    @else
                        {{ $user->name }}'s Note
                    @endif
                </h6>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" style="background-color: #121212;">
                @if (Auth::check() && Auth::id() === $user->id)

                    <form action="{{ route('note.store') }}" method="POST">
                        @csrf
                        <textarea name="content" class="ig-note-textarea" rows="3" placeholder="Share a thought...">{{ $user->note->content ?? '' }}</textarea>

                        <div class="d-flex gap-2 mt-3">
                            <button class="btn ig-btn-primary w-100">Save</button>
                    </form>

                    @if ($user->note)
                        <form action="{{ route('note.destroy') }}" method="POST" class="w-100">
                            @csrf
                            @method('DELETE')
                            <button class="btn ig-btn-danger w-100">Delete</button>
                        </form>
                    @endif
            </div>
        @else
            <textarea class="ig-note-textarea" rows="3" readonly>{{ $user->note->content ?? '' }}</textarea>
        @endif
        </div>

    </div>
</div>
</div>

{{-- Followers modal --}}
<div class="modal fade" id="followersModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content bg-black text-white" style="border-radius:16px; border: 1px solid #585656;">
   
            <div class="modal-header border-0">
                <h6 class="fw-bold mb-0">{{ ucfirst($user->name) }}'s Followers</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                @if ($user->followers->isNotEmpty())
                    @foreach ($user->followers as $follower)
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            
                            <div class="d-flex align-items-center">
                                <a href="{{ route('profile.show', $follower->follower->id) }}">
                                    @if ($follower->follower->avatar)
                                        <img src="{{ $follower->follower->avatar }}" alt="{{ $follower->follower->name }}" class="rounded-circle avatar-sm me-2">
                                    @else
                                        <i class="fa-solid fa-circle-user text-secondary icon-sm me-2"></i>
                                    @endif
                                </a>
                                <a href="{{ route('profile.show', $follower->follower->id) }}" class="text-white text-decoration-none fw-bold">
                                    {{ $follower->follower->name }}
                                </a>
                            </div>

                            {{-- Follow / Unfollow Button --}}
                            @if ($follower->follower->id != Auth::id())
                                @if ($follower->follower->isFollowed())
                                    <form action="{{ route('follow.destroy', $follower->follower->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-light btn-sm">Following</button>
                                    </form>
                                @else
                                    <form action="{{ route('follow.store', $follower->follower->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">Follow</button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    @endforeach
                @else
                    <p class="text-secondary text-center mb-0">No Followers</p>
                @endif
            </div>

        </div>
    </div>
</div>

{{-- following modal --}}
<div class="modal fade" id="followingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content bg-black text-white" style="border-radius:16px; border: 1px solid #585656;"">

            {{-- Modal Header --}}
            <div class="modal-header border-0">
                <h6 class="fw-bold mb-0">{{ ucfirst($user->name) }}'s Following</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            {{-- Modal Body --}}
            <div class="modal-body">
                @if ($user->following->isNotEmpty())
                    @foreach ($user->following as $following)
                        <div class="d-flex align-items-center justify-content-between mb-3">

                            <div class="d-flex align-items-center">
                                <a href="{{ route('profile.show', $following->following->id) }}">
                                    @if ($following->following->avatar)
                                        <img src="{{ $following->following->avatar }}" alt="{{ $following->following->name }}" class="rounded-circle avatar-sm me-2">
                                    @else
                                        <i class="fa-solid fa-circle-user text-secondary icon-sm me-2"></i>
                                    @endif
                                </a>
                                <a href="{{ route('profile.show', $following->following->id) }}" class="text-white text-decoration-none fw-bold">
                                    {{ $following->following->name }}
                                </a>
                            </div>

                            {{-- Follow / Unfollow Button --}}
                            @if ($following->following->id != Auth::id())
                                @if ($following->following->isFollowed())
                                    <form action="{{ route('follow.destroy', $following->following->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-light btn-sm">Following</button>
                                    </form>
                                @else
                                    <form action="{{ route('follow.store', $following->following->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">Follow</button>
                                    </form>
                                @endif
                            @endif

                        </div>
                    @endforeach
                @else
                    <p class="text-secondary text-center mb-0">Not following anyone</p>
                @endif
            </div>

        </div>
    </div>
</div>

<style>
    .btn-profile-action {
        background: #585656;
        color: #fff;
        border-radius: 8px;
        font-weight: 600;
    }

    .btn-profile-action:hover {
        background: #6f6d6d;
    }

</style>
