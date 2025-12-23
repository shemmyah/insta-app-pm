@extends('layouts.app')

@section('title', 'Show Post')

@section('content')
<div class="show-post-container">
    <div class="row g-0 main-post-card">
        {{-- Left Side: Image Section --}}
        <div class="col-lg-8 post-image-column">
            <div class="image-wrapper">
                <img src="{{ $post->image }}" alt="post id {{ $post->id }}" class="show-main-img">
                <div class="image-overlay-vignette"></div>
            </div>
        </div>

        {{-- Right Side: Details & Interaction Section --}}
        <div class="col-lg-4 post-details-column">
            {{-- Header: Author Info & Actions --}}
            <div class="post-header-glass">
                <div class="d-flex align-items-center justify-content-between w-100">
                    <a href="{{ route('profile.show', $post->user->id) }}" class="author-info">
                        <div class="author-avatar-styled">
                            @if ($post->user->avatar)
                                <img src="{{ $post->user->avatar }}" alt="{{ $post->user->name }}">
                            @else
                                {{ strtoupper(substr($post->user->name, 0, 1)) }}
                            @endif
                        </div>
                        <span class="author-name-text">{{ $post->user->name }}</span>
                    </a>

                    <div class="action-buttons">
                        @if (Auth::user()->id === $post->user->id)
                            <div class="dropdown">
                                <button class="btn-action-trigger" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                                    <a href="{{ route('post.edit', $post->id) }}" class="dropdown-item">
                                        <i class="fa-regular fa-pen-to-square me-2"></i> Edit
                                    </a>
                                    <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#delete-post-{{ $post->id }}">
                                        <i class="fa-regular fa-trash-can me-2"></i> Delete
                                    </button>
                                </div>
                                @include('users.posts.contents.modals.delete')
                            </div>
                        @else
                            @if ($post->user->isFollowed())
                                <form action="{{ route('follow.destroy', $post->user->id) }}" method="post">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="follow-btn followed">Following</button>
                                </form>
                            @else
                                <form action="{{ route('follow.store', $post->user->id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="follow-btn">Follow</button>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            {{-- Scrollable Content --}}
            <div class="post-scrollable-content">
                {{-- Categories & Description --}}
                <div class="content-padding">
                    <div class="category-tags-container mb-3">
                        @forelse ($post->categoryPost as $category_post)
                            <span class="category-tag-styled">{{ strtolower($category_post->category->name) }}</span>
                        @empty
                            <span class="category-tag-styled empty">uncategorized</span>
                        @endforelse
                    </div>

                    <p class="post-description-text">{{ $post->description }}</p>
                    <time class="post-date-text">{{ $post->created_at->format('M d, Y') }}</time>
                </div>

                <hr class="divider-glass">

                {{-- Comments Section --}}
                <div class="comments-container content-padding">
                    <h6 class="comments-title">Comments</h6>
                    @if ($post->comments->isNotEmpty())
                        @foreach ($post->comments as $comment)
                            <div class="comment-item">
                                <div class="comment-bubble">
                                    <a href="{{ route('profile.show', $comment->user->id) }}" class="commenter-name">{{ $comment->user->name }}</a>
                                    <p class="comment-body-text">{{ $comment->body }}</p>
                                </div>
                                <div class="comment-meta d-flex align-items-center gap-2">
                                    <span>{{ $comment->created_at->diffForHumans() }}</span>
                                    @if (Auth::user()->id === $comment->user->id)
                                        <form action="{{ route('comment.destroy', $comment->id) }}" method="post" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="comment-delete-btn">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="no-comments">No comments yet. Be the first to share your thoughts!</p>
                    @endif
                </div>
            </div>

            {{-- Bottom Sticky Bar: Likes & Input --}}
            <div class="post-footer-glass">
                <div class="footer-actions d-flex align-items-center mb-3">
                    <livewire:post-like :post="$post" />
                    <span class="likes-label ms-2">likes</span>
                </div>

                <form action="{{ route('comment.store', $post->id) }}" method="post" class="comment-form">
                    @csrf
                    <div class="comment-input-wrapper">
                        <textarea name="comment_body{{ $post->id }}" rows="1" placeholder="Add a comment..." required>{{ old('comment_body' . $post->id) }}</textarea>
                        <button type="submit" class="send-comment-btn">
                            <i class="fa-regular fa-paper-plane"></i>
                        </button>
                    </div>
                    @error('comment_body' . $post->id)
                        <div class="text-danger xsmall mt-1">{{ $message }}</div>
                    @enderror
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Layout Foundation */
    .show-post-container {
        max-width: 1200px;
        margin: 20px auto;
        border-radius: 16px;
        overflow: hidden;
        background: #0a0a0a;
        box-shadow: 0 20px 50px rgba(0,0,0,0.5);
    }

    .main-post-card { min-height: 80vh; }

    /* Left Side: Image */
    .post-image-column {
        background: #000;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    
    .image-wrapper { width: 100%; height: 100%; position: relative; }

    .show-main-img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
    }

    .image-overlay-vignette {
        position: absolute;
        inset: 0;
        background: radial-gradient(circle, transparent 50%, rgba(0,0,0,0.4) 100%);
        pointer-events: none;
    }

    /* Right Side: Details */
    .post-details-column {
        display: flex;
        flex-direction: column;
        background: #0f0f0f;
        border-left: 1px solid rgba(255,255,255,0.08);
        height: 80vh;
    }

    /* Header Styling */
    .post-header-glass {
        padding: 16px 20px;
        background: rgba(255,255,255,0.03);
        border-bottom: 1px solid rgba(255,255,255,0.06);
    }

    .author-info {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
    }

    .author-avatar-styled {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        overflow: hidden;
    }

    .author-avatar-styled img { width: 100%; height: 100%; object-fit: cover; }

    .author-name-text { color: #fff; font-weight: 600; font-size: 0.95rem; }

    .follow-btn {
        background: transparent;
        border: 1px solid #667eea;
        color: #667eea;
        padding: 4px 16px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .follow-btn:hover { background: #667eea; color: #fff; }
    .follow-btn.followed { border-color: rgba(255,255,255,0.2); color: rgba(255,255,255,0.6); }

    .btn-action-trigger {
        background: transparent; border: none; color: rgba(255,255,255,0.5); font-size: 1.2rem;
    }

    /* Scrollable Content Section */
    .post-scrollable-content {
        flex-grow: 1;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: rgba(255,255,255,0.1) transparent;
    }

    .content-padding { padding: 20px; }

    .category-tag-styled {
        background: rgba(102, 126, 234, 0.1);
        border: 1px solid rgba(102, 126, 234, 0.25);
        color: #667eea;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 0.7rem;
        font-weight: 600;
        margin-right: 6px;
    }

    .post-description-text { color: rgba(255,255,255,0.9); line-height: 1.6; font-size: 0.95rem; margin-bottom: 8px; }
    .post-date-text { color: rgba(255,255,255,0.4); font-size: 0.75rem; text-transform: uppercase; }

    .divider-glass { border-top: 1px solid rgba(255,255,255,0.06); margin: 0; }

    /* Comments Section */
    .comments-title { color: #fff; font-size: 0.85rem; font-weight: 700; margin-bottom: 15px; text-transform: uppercase; letter-spacing: 1px; }
    
    .comment-item { margin-bottom: 16px; }
    .comment-bubble { background: rgba(255,255,255,0.04); padding: 12px; border-radius: 12px; margin-bottom: 4px; }
    .commenter-name { color: #667eea; font-weight: 700; text-decoration: none; font-size: 0.85rem; display: block; margin-bottom: 2px; }
    .comment-body-text { color: rgba(255,255,255,0.85); font-size: 0.9rem; margin: 0; }
    .comment-meta { font-size: 0.75rem; color: rgba(255,255,255,0.4); padding-left: 8px; }
    .comment-delete-btn { background: none; border: none; color: #ff4d4d; font-size: 0.75rem; cursor: pointer; padding: 0; }

    /* Footer Section */
    .post-footer-glass {
        padding: 20px;
        background: rgba(255,255,255,0.02);
        border-top: 1px solid rgba(255,255,255,0.06);
    }

    .likes-label { color: rgba(255,255,255,0.7); font-weight: 600; font-size: 0.9rem; }

    .comment-input-wrapper {
        display: flex;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 25px;
        padding: 8px 16px;
        align-items: center;
    }

    .comment-input-wrapper textarea {
        flex-grow: 1;
        background: transparent;
        border: none;
        color: white;
        padding: 4px 0;
        font-size: 0.9rem;
        resize: none;
        outline: none;
    }

    .send-comment-btn {
        background: none; border: none; color: #667eea; font-size: 1.1rem; padding-left: 10px; transition: transform 0.2s ease;
    }
    .send-comment-btn:hover { transform: translateX(3px); color: #764ba2; }

    /* Mobile Adaptations */
    @media (max-width: 992px) {
        .post-details-column { height: auto; border-left: none; border-top: 1px solid rgba(255,255,255,0.08); }
        .post-scrollable-content { max-height: 400px; }
    }
</style>
@endsection