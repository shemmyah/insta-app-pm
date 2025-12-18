<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [];

    #多対多リレーション(Conversation↔︎User)
    public function users() {
       return $this->belongsToMany(User::class);
    }

    #1対多リレーション(Message→Conversation)
    public function messages() {
       return $this->hasMany(Message::class);
    }

    #新着メッセージ１件だけを取得（DM一覧用）
    public function lastMessage() {
       return $this->hasOne(Message::class)->latestOfMany();
    }

    #相手ユーザーの取得
    public function otherUserFor(int $userId) {
       return $this->users()
            ->where('users_id', '!=', $userId)
            ->first();
    }

}
