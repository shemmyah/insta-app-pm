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

    #1対多リレーション(→Conversation→Message)
    public function messages() {
       return $this->hasMany(Message::class);
    }

    #新着メッセージを取得（DM一覧用）
    public function lastMessage() {
       return $this->hasOne(Message::class)->latestOfMany();
    }

    #相手ユーザーの取得
    public function otherUserFor($authuserId) {
       return $this->users()
            ->where('user_id', '!=', $authuserId)
            ->first();
    }

    public function getOtherUserAttribute() {
       return $this->otherUserFor(auth()->id());
    }

}
