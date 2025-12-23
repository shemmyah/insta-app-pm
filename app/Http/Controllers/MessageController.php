<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Conversation;
use App\Notifications\NewMessageNotification;
use App\Models\Message;

class MessageController extends Controller
{
    public function index()
    {
        $authUser = auth()->user();

        // Fetch all conversations where the user participates
        $conversations = Conversation::with(['users', 'lastMessage'])
            ->whereHas('users', function ($q) use ($authUser) {
                $q->where('users.id', $authUser->id);
            })
            ->latest('updated_at')
            ->get();

        // Add the "other_user" property for convenience in Blade
        $conversations->each(function ($conv) use ($authUser) {
            $conv->other_user = $conv->users->firstWhere('id', '!=', $authUser->id);
        });

        return view('users.messages.index', [
            'conversations' => $conversations,
            'conversation' => null, // no conversation selected
            'authUser' => $authUser,
        ]);
    }

    public function show(Conversation $conversation)
    {
        $authUser = auth()->user();

        // Ensure the user is part of this conversation
        abort_unless($conversation->users->contains($authUser->id), 403);

        // Mark all message notifications for this conversation as read
        $authUser->unreadNotifications
            ->where('type', 'App\Notifications\NewMessageNotification')
            ->where('data.conversation_id', $conversation->id)
            ->markAsRead();

        // Fetch all conversations for the sidebar (no filters)
        $conversations = Conversation::with(['users', 'lastMessage'])
            ->whereHas('users', function ($q) use ($authUser) {
                $q->where('users.id', $authUser->id);
            })
            ->latest('updated_at')
            ->get();

        $conversations->each(function ($conv) use ($authUser) {
            $conv->other_user = $conv->users->firstWhere('id', '!=', $authUser->id);
        });

        // Load messages for the selected conversation
        $conversation->load('messages.sender');

        return view('users.messages.index', [
            'conversations' => $conversations,
            'conversation' => $conversation,
            'authUser' => $authUser,
        ]);
    }




    public function store(Request $request, Conversation $conversation)
    {
        abort_unless(
            $conversation->users->contains(auth()->id()),
            403
        );

        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $message = $conversation->messages()->create([
            'sender_id' => auth()->id(),
            'body' => $request->body,
        ]);

        $conversation->users->where('id', '!=', auth()->id())
            ->each(function ($user) use ($message) {
                $user->notify(new NewMessageNotification($message));
            });

        return redirect()->route('messages.show', $conversation->id);
    }



    #DM開始（プロフィールの「メッセージを送る」用）

    public function start(User $user)
    {
        $authUser = auth()->user();

        // 自分自身にはDMできない
        if ($authUser->id === $user->id) {
            return back();
        }

        #既存の会話を探す
        $conversation = Conversation::whereHas('users', function ($q) use ($authUser) {
            $q->where('users.id', $authUser->id);
        })->whereHas('users', function ($q) use ($user) {
            $q->where('users.id', $user->id);
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



