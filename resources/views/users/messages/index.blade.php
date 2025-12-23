@extends('layouts.app')

@section('title', 'Messages')

@section('content')
<div class="message-wrapper">
    <div class="message-container">
        
        {{-- LEFT SIDEBAR: Conversations --}}
        <div class="msg-sidebar">
            <div class="sidebar-header">
                <h5 class="m-0 fw-bold">Messages</h5>
            </div>
            <div class="conversation-list">
                @foreach ($conversations as $conv)
                    @php
                        $isUnread = auth()->user()->unreadNotifications
                            ->where('type', 'App\Notifications\NewMessageNotification')
                            ->where('data.conversation_id', $conv->id)
                            ->count() > 0;
                        $isActive = optional($conversation)->id === $conv->id;
                    @endphp

                    <a href="{{ route('messages.show', $conv->id) }}" class="conv-item {{ $isActive ? 'active' : '' }}">
                        <div class="avatar-wrapper">
                            @if ($conv->other_user?->avatar)
                                <img src="{{ $conv->other_user->avatar }}" class="conv-avatar">
                            @else
                                <div class="conv-avatar-default">
                                    <i class="fa-solid fa-user fs-5"></i>
                                </div>
                            @endif
                            @if($isUnread) <span class="unread-badge"></span> @endif
                        </div>

                        <div class="conv-info">
                            <div class="conv-name-row">
                                <span class="conv-name">{{ $conv->other_user?->name }}</span>
                            </div>
                            <div class="conv-last-msg">
                                {{ Str::limit($conv->lastMessage?->body ?? 'No messages yet...', 30) }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- RIGHT SIDE: Chat Area --}}
        <div class="msg-main">
            @if ($conversation)
                {{-- Chat Header --}}
                <div class="chat-header">
                    <div class="d-flex align-items-center gap-3">
                        @php $otherUser = $conversation->users->where('id', '!=', auth()->id())->first(); @endphp
                        <div class="avatar-sm">
                            @if ($otherUser->avatar)
                                <img src="{{ $otherUser->avatar }}" class="conv-avatar-sm">
                            @else
                                <div class="conv-avatar-sm-default"><i class="fa-solid fa-user"></i></div>
                            @endif
                        </div>
                        <div>
                            <h6 class="m-0 fw-bold text-white">{{ $otherUser->name }}</h6>
                            {{-- <small class="text-success" style="font-size: 10px;">● Online</small> --}}
                        </div>
                    </div>
                </div>

                {{-- Messages Display --}}
                <div class="chat-body" id="chatBody">
                    @foreach ($conversation->messages as $message)
                        <div class="message-row {{ $message->sender_id === auth()->id() ? 'me' : 'other' }}">
                            @if ($message->sender_id !== auth()->id())
                                <div class="msg-avatar">
                                    @if ($message->sender->avatar)
                                        <img src="{{ $message->sender->avatar }}" class="rounded-circle" width="28" height="28">
                                    @else
                                        <i class="fa-solid fa-circle-user text-secondary fs-4"></i>
                                    @endif
                                </div>
                            @endif
                            <div class="msg-bubble shadow-sm">
                                {{ $message->body }}
                                <div class="msg-time">{{ $message->created_at->format('H:i') }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Chat Input --}}
                <div class="chat-footer">
                    <form action="{{ route('messages.store', $conversation->id) }}" method="post" class="msg-input-container">
                        @csrf
                        <input type="text" name="body" class="msg-input" placeholder="Type a message..." autocomplete="off" required>
                        <button type="submit" class="msg-send-btn">
                            <i class="fa-solid fa-paper-plane fs-5"></i>
                        </button>
                    </form>
                </div>
            @else
                {{-- Empty State --}}
                <div class="empty-chat">
                    <div class="text-center">
                        <i class="fa-regular fa-comment-dots mb-3 opacity-25" style="font-size: 5rem;"></i>
                        <h5 class="text-white">Your Messages</h5>
                        <p class="text-secondary">Select a conversation to start chatting.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
/* Base Setup */
.message-wrapper {
    padding: 20px;
    height: calc(100vh - 100px);
    display: flex;
    justify-content: center;
}

.message-container {
    width: 100%;
    max-width: 1100px;
    background: #0f1720;
    border: 1px solid #22303c;
    border-radius: 20px;
    display: flex;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(0,0,0,0.5);
}

/* Sidebar Styling */
.msg-sidebar {
    width: 320px;
    border-right: 1px solid #22303c;
    display: flex;
    flex-direction: column;
    background: rgba(15, 23, 32, 0.5);
}

.sidebar-header {
    padding: 24px;
    border-bottom: 1px solid #22303c;
    color: #fff;
}

.conversation-list {
    flex-grow: 1;
    overflow-y: auto;
}

.conv-item {
    display: flex;
    align-items: center;
    padding: 12px 20px;
    text-decoration: none;
    transition: all 0.2s ease;
    gap: 12px;
}

.conv-item:hover {
    background: rgba(255, 255, 255, 0.03);
}

.conv-item.active {
    background: rgba(29, 155, 240, 0.1);
    border-right: 3px solid #1d9bf0;
}

/* Avatar Logic - Smaller as requested */
.avatar-wrapper { position: relative; }
.conv-avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
.conv-avatar-default { 
    width: 40px; height: 40px; border-radius: 50%; 
    background: #22303c; display: flex; align-items: center; 
    justify-content: center; color: #5c6d7e; 
}

.unread-badge {
    position: absolute;
    top: 0;
    right: 0;
    width: 11px;
    height: 11px;
    background: #1d9bf0;
    border: 2px solid #0f1720;
    border-radius: 50%;
}

.conv-info { flex-grow: 1; overflow: hidden; }
.conv-name { color: #fff; font-weight: 700; font-size: 0.9rem; }
.conv-last-msg { color: #71767b; font-size: 0.8rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

/* Main Chat Area */
.msg-main { flex-grow: 1; display: flex; flex-direction: column; background: #0b1118; }

.chat-header {
    padding: 12px 24px;
    border-bottom: 1px solid #22303c;
    background: #0f1720;
}

.conv-avatar-sm, .conv-avatar-sm-default {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
}

.conv-avatar-sm-default {
    background: #22303c;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #5c6d7e;
    font-size: 0.8rem;
}

.chat-body {
    flex-grow: 1;
    overflow-y: auto;
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

/* Bubbles Styling */
.message-row { display: flex; align-items: flex-end; gap: 10px; max-width: 80%; }
.message-row.me { align-self: flex-end; flex-direction: row-reverse; }
.message-row.other { align-self: flex-start; }

.msg-bubble {
    padding: 10px 16px;
    border-radius: 18px;
    font-size: 0.95rem;
    line-height: 1.4;
}

.me .msg-bubble {
    background: #1d9bf0;
    color: #fff;
    border-bottom-right-radius: 4px;
}

.other .msg-bubble {
    background: #22303c;
    color: #e6edf3;
    border-bottom-left-radius: 4px;
}

.msg-time { font-size: 10px; opacity: 0.6; margin-top: 4px; text-align: right; }

/* Input Footer */
.chat-footer { padding: 15px 20px; background: #0f1720; border-top: 1px solid #22303c; }
.msg-input-container {
    background: #16202c;
    border-radius: 25px;
    padding: 5px 5px 5px 18px;
    display: flex;
    align-items: center;
    border: 1px solid transparent;
    transition: border 0.2s;
}

.msg-input-container:focus-within {
    border-color: #1d9bf0;
}

.msg-input {
    flex-grow: 1;
    background: none;
    border: none;
    color: #fff;
    outline: none;
    font-size: 0.9rem;
    padding: 8px 0;
}

.msg-send-btn {
    background: #1d9bf0;
    color: #fff;
    border: none;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.2s, background 0.2s;
}

.msg-send-btn:hover {
    transform: scale(1.05);
    background: #1a8cd8;
}

.empty-chat { flex-grow: 1; display: flex; align-items: center; justify-content: center; }

/* Custom Scrollbar for modern look */
.conversation-list::-webkit-scrollbar,
.chat-body::-webkit-scrollbar { width: 5px; }
.conversation-list::-webkit-scrollbar-thumb,
.chat-body::-webkit-scrollbar-thumb { background: #22303c; border-radius: 10px; }
</style>

<script>
    // Ensure chat starts at bottom
    document.addEventListener("DOMContentLoaded", function() {
        const chatBody = document.getElementById('chatBody');
        if(chatBody) {
            chatBody.scrollTop = chatBody.scrollHeight;
        }
    });
</script>
@endsection