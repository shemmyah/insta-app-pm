<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;

class MessageController extends Controller
{
    #DMトップ（左：会話一覧/右：未選択）
    public function index(){
        $conversations = auth()->user()
            ->conversations()
            ->with(['users', 'lastMessage'])
            ->get();

        return view('users.messages.index', [
            'conversations' => $conversations,
            'conversation'  => null,
           
        ]);
    }

    
     #会話を選択した状態（左：一覧 / 右：チャット）
    public function show(Conversation $conversation){
        #自分が参加していない会話は見れない
        // abort_unless(
        //     $conversation->users->contains(auth()->id()),
        //     403
        // );

        $conversations = auth()->user()
            ->conversations()
            ->with(['users', 'lastMessage'])
            ->get();

        #メッセージは古い → 新しい順
        $conversation->load('messages.sender');

        return view('users.messages.index', [
            'conversations' => $conversations,
            'conversation'  => $conversation,
        ]);
    }

    
     #メッセージ送信
     
    public function store(Request $request, Conversation $conversation){
        abort_unless(
            $conversation->users->contains(auth()->id()),
            403
        );

        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $conversation->messages()->create([
            'sender_id' => auth()->id(),
            'body'      => $request->body,
        ]);

        return redirect()->route('messages.show', $conversation->id);
    }

    
    #DM開始（プロフィールの「メッセージを送る」用）
     
    public function start(User $user){
        $authUser = auth()->user();

        // 自分自身にはDMできない
        if ($authUser->id === $user->id) {
            return back();
        }

        #既存の会話を探す
        $conversation = Conversation::whereHas('users', function ($q) use ($authUser) {
            $q->where('user_id', $authUser->id);
        })->whereHas('users', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->first();

        #なければ作成
        if (!$conversation) {
            $conversation = Conversation::create();
            $conversation->users()->attach([
                $authUser->id,
                $user->id,
            ]);
        }

        return redirect()->route('messages.show', $conversation->id);
    }
}
    


