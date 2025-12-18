<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Story;

class StoryController extends Controller
{
    private $story;

    public function __construct(Story $story) {
       $this->story=$story;
    }

    public function create() {
        // dd(Auth::user()->id);
        $story = $this->story->latest()->get();
        return view('users.story.create');
    }

    public function store(Request $request)
    {
    $request->validate([
        'media_path'  => 'required|file|mimes:jpeg,jpg,png,gif,mp4,mov|max:10240',
        'media_type'  => 'required|in:image,video',
    ]);

    $story = new Story();
    $story->user_id    = Auth::id();
    $story->media_path = 'data:' . $request->file('media_path')->extension() 
                         . ';base64,' . base64_encode(file_get_contents($request->file('media_path')));
    $story->media_type = $request->media_type;
    $story->save();

    return redirect()->back()->with('success', 'Story uploaded!');
    }

}
