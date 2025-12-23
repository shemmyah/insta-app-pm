<div class="profile-header">

    <div class="row mb-3">
        <div class="col-4 text-center">
            <div class="avatar-container">
                @if ($user->avatar)
                    <img src="{{ $user->avatar }}" class="profile-avatar">
                @else
                    <i class="fa-solid fa-circle-user profile-avatar-icon"></i>
                @endif

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
                <a href="#" class="text-decoration-none text-white btn-link" data-bs-toggle="modal"
                    data-bs-target="#followersModal">
                    <strong>{{ $user->followers->count() }}</strong>
                    {{ $user->followers->count() == 1 ? 'follower' : 'followers' }}
                </a>
                <a href="#" class="text-decoration-none text-white btn-link" data-bs-toggle="modal"
                    data-bs-target="#followingModal">
                    <strong>{{ $user->following->count() }}</strong> following
                </a>
            </div>

            <p class="profile-bio">{{ $user->introduction ?: 'No bio yet.' }}</p>
        </div>
    </div>


    <div class="row gx-2">
        <div class="col-6">
            @if (Auth::check() && Auth::id() === $user->id)

                <a href="{{ route('profile.edit') }}" class="btn btn-profile-modern btn-primary-modern w-100">
                    <i class="fa-solid fa-user-pen"></i> Edit Profile
                </a>
            @else
 
                <form
                    action="{{ $user->isFollowed() ? route('follow.destroy', $user->id) : route('follow.store', $user->id) }}"
                    method="POST">
                    @csrf
                    @if ($user->isFollowed())
                        @method('DELETE')
                    @endif
                    <button type="submit"
                        class="btn btn-profile-modern w-100 {{ $user->isFollowed() ? 'btn-secondary-modern' : 'btn-primary-modern' }}">
                        @if ($user->isFollowed())
                            <i class="fa-solid fa-user-check"></i> Following
                        @else
                            <i class="fa-solid fa-user-plus"></i> Follow
                        @endif
                    </button>
                </form>
            @endif
        </div>

        <div class="col-6">
            @if (Auth::check() && Auth::id() === $user->id)
                <button class="btn btn-profile-modern btn-secondary-modern w-100"
                    onclick="navigator.clipboard.writeText(window.location.href)">
                    <i class="fa-solid fa-share"></i> Share Profile
                </button>
            @else
                <a href="{{ route('messages.start', $user->id) }}"
                    class="btn btn-profile-modern btn-secondary-modern w-100">
                    <i class="fa-solid fa-envelope"></i> Message {{ ucfirst($user->name) }}
                </a>
            @endif
        </div>
    </div>

</div>


<div class="modal fade" id="noteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content modal-modern">
            <div class="modal-header-modern">
                <h6 class="modal-title-modern">
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
                <button class="btn-close-modern" data-bs-dismiss="modal"><i class="fa-solid fa-close"></i></button>
            </div>

            <div class="modal-body-modern">
                @if (Auth::check() && Auth::id() === $user->id)
                    <form action="{{ route('note.store') }}" method="POST">
                        @csrf
                        <textarea name="content" class="note-textarea-modern" rows="4" placeholder="Share a thought...">{{ $user->note->content ?? '' }}</textarea>

                        <div class="modal-actions">
                            <button type="submit" class="btn-modal-primary w-100">Save Note</button>
                    </form>

                    @if ($user->note)
                        <form action="{{ route('note.destroy') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-modal-danger w-100">Delete</button>
                        </form>
                    @endif
            </div>
        @else
            <textarea class="note-textarea-modern" rows="4" readonly>{{ $user->note->content ?? '' }}</textarea>
            @endif
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="followersModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content modal-modern">
            <div class="modal-header-modern">
                <h6 class="modal-title-modern">Followers</h6>
                <button class="btn-close-modern" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <div class="modal-body-modern">
                @if ($user->followers->isNotEmpty())
                    @foreach ($user->followers as $follower)
                        <div class="user-list-item">
                            <div class="user-list-info">
                                <a href="{{ route('profile.show', $follower->follower->id) }}"
                                    class="user-avatar-wrapper">
                                    @if ($follower->follower->avatar)
                                        <img src="{{ $follower->follower->avatar }}" class="user-list-img">
                                    @else
                                        <div class="user-list-icon-default">
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                    @endif
                                </a>
                                <a href="{{ route('profile.show', $follower->follower->id) }}" class="user-list-name">
                                    {{ $follower->follower->name }}
                                </a>
                            </div>

                            @if ($follower->follower->id != Auth::id())
                                <form
                                    action="{{ $follower->follower->isFollowed() ? route('follow.destroy', $follower->follower->id) : route('follow.store', $follower->follower->id) }}"
                                    method="POST">
                                    @csrf
                                    @if ($follower->follower->isFollowed())
                                        @method('DELETE')
                                    @endif
                                    <button type="submit"
                                        class="btn-follow-toggle {{ $follower->follower->isFollowed() ? 'following' : '' }}">
                                        {{ $follower->follower->isFollowed() ? 'Following' : 'Follow' }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="fa-solid fa-users mb-2 d-block opacity-25" style="font-size: 2rem;"></i>
                        <p>No followers yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="followingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content modal-modern">
            <div class="modal-header-modern">
                <h6 class="modal-title-modern">Following</h6>
                <button class="btn-close-modern" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <div class="modal-body-modern">
                @if ($user->following->isNotEmpty())
                    @foreach ($user->following as $following)
                        <div class="user-list-item">
                            <div class="user-list-info">
                                <a href="{{ route('profile.show', $following->following->id) }}"
                                    class="user-avatar-wrapper">
                                    @if ($following->following->avatar)
                                        <img src="{{ $following->following->avatar }}" class="user-list-img">
                                    @else
                                        <div class="user-list-icon-default">
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                    @endif
                                </a>
                                <a href="{{ route('profile.show', $following->following->id) }}"
                                    class="user-list-name">
                                    {{ $following->following->name }}
                                </a>
                            </div>

                            @if ($following->following->id != Auth::id())
                                <form
                                    action="{{ $following->following->isFollowed() ? route('follow.destroy', $following->following->id) : route('follow.store', $following->following->id) }}"
                                    method="POST">
                                    @csrf
                                    @if ($following->following->isFollowed())
                                        @method('DELETE')
                                    @endif
                                    <button type="submit"
                                        class="btn-follow-toggle {{ $following->following->isFollowed() ? 'following' : '' }}">
                                        {{ $following->following->isFollowed() ? 'Following' : 'Follow' }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="fa-solid fa-user-plus mb-2 d-block opacity-25" style="font-size: 2rem;"></i>
                        <p>Not following anyone</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<style>
    /* Modern Buttons */
    .btn-profile-modern {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-primary-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .btn-primary-modern:hover {
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        transform: translateY(-2px);
        color: #fff;
    }

    .btn-secondary-modern {
        background: rgba(255, 255, 255, 0.05);
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.15);
    }

    .btn-secondary-modern:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.25);
        transform: translateY(-2px);
        color: #fff;
    }

    /* Modal Modern */
    .modal-modern {
        background: rgba(15, 15, 15, 0.98);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 16px;
        color: #fff;
    }

    .modal-header-modern {
        padding: 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-title-modern {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
        font-weight: 700;
        font-size: 1rem;
    }

    .btn-close-modern {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        padding: 0;
    }

    .btn-close-modern:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.2);
    }

    /* Note Textarea & Modal Actions */
    .note-textarea-modern {
        width: 100%;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 12px;
        color: #fff;
        font-size: 0.9rem;
        resize: none;
        font-family: inherit;
        transition: all 0.3s ease;
    }

    .note-textarea-modern:focus {
        outline: none;
        border-color: rgba(102, 126, 234, 0.5);
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .modal-actions {
        display: flex;
        gap: 10px;
        margin-top: 16px;
    }

    .btn-modal-primary,
    .btn-modal-danger {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-modal-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
    }

    .btn-modal-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .btn-modal-danger {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .btn-modal-danger:hover {
        background: rgba(239, 68, 68, 0.2);
        border-color: rgba(239, 68, 68, 0.5);
        transform: translateY(-2px);
    }

    /* Follow Toggle Button */
    .btn-follow-toggle {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: #fff;
        padding: 8px 20px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
    }

    .btn-follow-toggle:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.5);
    }

    .btn-follow-toggle.following {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: rgba(255, 255, 255, 0.8);
        box-shadow: none;
    }

    .btn-follow-toggle.following:hover {
        background: rgba(239, 68, 68, 0.1);
        border-color: rgba(239, 68, 68, 0.4);
        color: #ef4444;
    }

    /* User List Layout */
    .user-list-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .user-list-item:last-child {
        border-bottom: none;
    }

    .user-list-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    /* Avatar & Icon Styling */
    .user-avatar-wrapper {
        text-decoration: none;
    }

    .user-list-img {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .user-list-icon-default {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255, 255, 255, 0.5);
        font-size: 1.1rem;
    }

    .user-list-name {
        color: #fff;
        font-weight: 500;
        font-size: 0.9rem;
        text-decoration: none;
    }

    .user-list-name:hover {
        color: #667eea;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 40px 0;
        color: rgba(255, 255, 255, 0.4);
    }

    /* Smaller follow button for list view */
    .btn-follow-toggle {
        padding: 6px 14px;
        font-size: 0.75rem;
        border-radius: 20px;
    }
</style>
