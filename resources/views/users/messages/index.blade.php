<div class="container-fluid">
    <div class="row d-flex flex-row">

        {{-- 左：会話一覧 --}}
        <div class="col-4 border-end" style="height: 80vh; overflow-y: auto;">
            @foreach ($conversations as $conv)
                <a href="{{ route('messages.show', $conv->id) }}" class="text-decoration-none text-dark">

                    <div class="p-2 {{ optional($conversation)->id === $conv->id ? 'bg-light' : ' ' }}">
                        {{-- アイコン --}}
                        {{-- @if ($user->avatar)
                          <img src="{{ $user->avatar }}" class="rounded-circle avatar-sm">
                          @else
                           <i class="fa-solid fa-circle-user icon-md text-muted"></i>
                          @endif --}}
                        {{-- ユーザー名 --}}
                        <strong>{{ optional($conv->otherUserFor(auth()->id()))->name }}</strong><br>
                        {{-- 直近のメッセージ --}}
                        <small class="text-muted">{{ optional($conv->lastMessage)->body }}</small>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- 右：チャット画面 --}}
        <div class="col-8" style="height: 80vh">
            @if ($conversation)

                {{-- ヘッダー --}}
                <div class="border-bottom p-2">
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
    {{-- @unless($isMe)
      @if ($sender->avatar)
        <img src="{{ $sender->avatar }}" class="rounded-circle avatar-sm me-2">
      @else
        <i class="fa-solid fa-circle-user icon-md text-muted me-2"></i>
      @endif
    @endunless --}}
                            <div class="chat-bubble {{ $message->sender_id === auth()->id() ? 'me' : 'other' }}">
                                {{ $message->body }}
                            </div>
                            {{-- 自分のアイコン --}}
    {{-- @if($isMe)
      @if (auth()->user()->avatar)
        <img src="{{ auth()->user()->avatar }}" class="rounded-circle avatar-sm ms-2">
      @else
        <i class="fa-solid fa-circle-user icon-md text-muted ms-2"></i>
      @endif
    @endif --}}
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
                <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                    きらりんちょ⭐︎
                </div>
            @endif
        </div>
    </div>
</div>
