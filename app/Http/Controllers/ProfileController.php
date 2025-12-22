<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function show($id)
    {
        // Load user with note
        $user = $this->user->with('note')->findOrFail($id);

        // If the note exists and is older than 24 hours, delete it
        if ($user->note && $user->note->created_at->diffInHours(now()) >= 24) {
            $user->note->delete();
            $user->load('note'); // Reload the relation so note becomes null
        }

        return view('users.profile.show')->with('user', $user);
    }

    public function edit()
    {
        $user = $this->user->findOrFail(Auth::user()->id);
        return view('users.profile.edit')->with('user', $user);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|min:1|max:50',
            'email' => 'required|email|max:50|unique:users,email,' . Auth::user()->id,
            'avatar' => 'mimes:jpg,jpeg,gif,png|max:1048',
            'introduction' => 'max:100'
        ]);

        $user = $this->user->findOrFail(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->introduction = $request->introduction;

        if ($request->avatar) {
            $user->avatar = 'data:image/' . $request->avatar->extension() . ';base64,' . base64_encode(file_get_contents($request->avatar));
        }

        #Save
        $user->save();

        return redirect()->route('profile.show', Auth::user()->id);
    }

    #To open followers page
    public function followers($id)
    {
        $user = $this->user->findOrFail($id);
        return view('users.profile.followers')->with('user', $user);
    }

    #To open following page
    public function following($id)
    {
        $user = $this->user->findOrFail($id);
        return view('users.profile.following')->with('user', $user);
    }

    public function liked(User $user)
{
    $likedPosts = $user->likedPosts()
        ->with(['likes', 'comments'])
        ->latest()
        ->get();

    return view('users.profile.liked', compact('user', 'likedPosts'));
}
}
