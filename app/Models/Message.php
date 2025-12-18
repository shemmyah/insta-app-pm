<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['conversation_id', 'sender_id', 'body'];

    #多対１(Message→Conversation)
    public function conversation() {
        return $this->belongsTo(Conversation::class);
    }

     #多対１(Message→User/sender)
    public function sender() {
       return $this->belongsTo(User::class, 'sender_id');
    }


}
