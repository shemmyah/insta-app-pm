<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User;

class StoryController extends Controller
{
    private $user;

    public function __construct(User $user) {
       $this->user=$user;
    }
    public function () {
        $users = User::whereHas('stories', function ($query) {
        $query->where('expires_at', '>', now());
        })->get();

        return view('users.stories')->with('users',$users);
    }
}
