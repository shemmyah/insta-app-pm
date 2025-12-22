@extends('layouts.app')

@section('title', 'Message')

@section('content')
    <div class="container-fluid">
        <div class="row d-flex flex-row">

            {{-- 左：会話一覧 --}}
            <div class="col-3 border-end" style="height: 80vh; overflow-y: auto;">
                @foreach ($conversations as $conv)
                    <a href="{{ route('messages.show', $conv->id) }}" class="text-decoration-none text-dark">


                        <div
                            class="p-2 d-flex align-items-center{{ optional($conversation)->id === $conv->id ? 'bg-light' : ' ' }}">
                            {{-- 相手のアイコン --}}
                            @if ($conv->other_user?->avatar)
                                <img src="{{ $conv->other_user->avatar }}" class="rounded-circle avatar-md flex-shrink-0">
                            @else
                                <i class="fa-solid fa-circle-user icon-md text-muted flex-shrink-0"></i>
                            @endif

                            {{-- 相手のユーザー名 --}}
                            <div class="ms-2 flex-grow-1 overflow-hidden">
                                <div class="fw-bold text-white">
                                    {{ $conv->other_user?->name }}
                                </div>

                                {{-- 直近のメッセージ --}}
                                <div class="text-secondary small">
                                    {{ $conv->lastMessage?->body ?? 'No Message...' }}
                                </div>
                            </div>

                        </div>
                    </a>
                @endforeach
            </div>

            {{-- 右：チャット画面 --}}
            <div class="col-9 d-flex flex-column" style="height: 80vh">
                @if ($conversation)

                    {{-- ヘッダー --}}
                    <div class="border-bottom p-2 bg-primary text-white">
                        <strong>
                            {{ $conversation->users->where('id', '!=', auth()->id())->first()->name }}
                        </strong>
                    </div>

                    {{-- メッセージ --}}
                    <div class="flex-grow-1 overflow-auto p-3">
                        @foreach ($conversation->messages as $message)
                            <div
                                class="d-flex mb-2 {{ $message->sender_id === auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">

                                {{-- 相手のアイコン --}}
                                @if ($message->sender_id !== auth()->id())
                                    @if ($message->sender->avatar)
                                        <img src="{{ $message->sender->avatar }}" class="rounded-circle avatar-sm me-2">
                                    @else
                                        <i class="fa-solid fa-circle-user icon-md text-muted me-2"></i>
                                    @endif
                                @endif
                                <div class="chat-bubble {{ $message->sender_id === auth()->id() ? 'me' : 'other' }}">
                                    {{ $message->body }}
                                </div>
                                {{-- 自分のアイコン --}}
                                @if ($message->sender_id == auth()->id())
                                    @if ($message->sender->avatar)
                                        <img src="{{ $message->sender->avatar }}" class="rounded-circle avatar-sm me-2">
                                    @else
                                        <i class="fa-solid fa-circle-user icon-md text-muted me-2"></i>
                                    @endif
                                @endif
                            </div>
                        @endforeach
                    </div>

                    {{-- 入力欄 --}}
                    <form action="{{ route('messages.store', $conversation->id) }}" method="post"
                        class="d-flex p-2 border-top">
                        @csrf
                        <input type="text" name="body" class="form-control" placeholder="Message...">
                        <button class="btn btn-primary">Send</button>
                    </form>
                @else
                    <div class="d-flex align-items-center justify-content-center h-100 text-secondary">
                         Let's start a conversation!!
                    </div>
                @endif
            </div>
        </div>
    </div>


@endsection
