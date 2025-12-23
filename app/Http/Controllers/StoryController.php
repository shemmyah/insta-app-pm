<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Story;
use Illuminate\Support\Str;
use Mockery\Generator\Method;
use Carbon\Carbon;

class StoryController extends Controller
{
    private $story;

    public function __construct(Story $story)
    {
        $this->story = $story;
    }

    public function create()
    {
        // dd(Auth::user()->id);
        $story = $this->story->latest()->get();
        return view('users.story.create', [
        'id' => Auth::user()->id
        ]);

    }




    // public function store(Request $request)
    // {
    // $request->validate([
    //     'media_path'  => 'required|file|mimes:jpeg,jpg,png,gif,mp4,mov|max:10240',
    //     'media_type'  => 'required|in:image,video',
    // ]);

    // $story = new Story();
    // $story->user_id    = Auth::id();
    // $story->media_path = 'data:' . $request->file('media_path')->extension() 
    //                      . ';base64,' . base64_encode(file_get_contents($request->file('media_path')));
    // $story->media_type = $request->media_type;
    // $story->save();

    // return redirect()->back()->with('success', 'Story uploaded!');
    // }

    //     public function edit(Request $request) {
    //       $request->validate([
    //         'media' => 'required|file|max:20480', // 20MB
    //     ]);

    //     $file = $request->file('media');
    //     $mime = $file->getMimeType();


    //     if (Str::startsWith($mime, 'image/')) {
    //         $mediaType = 'image';
    //         $path = $file->store('stories/temp/images', 'public');
    //     } elseif (Str::startsWith($mime, 'video/')) {
    //         $mediaType = 'video';
    //         $path = $file->store('stories/temp/videos', 'public');
    //     } else {
    //         abort(400, 'Invalid media type');
    //     }

    //     return view('users.story.edit', [
    //         'mediaPath' => $path,
    //         'mediaType' => $mediaType,
    //     ]);
    // }

    // public function edit(Request $request,$id)
    // {
    //     $story = Story::findOrFail($id);
       
        

    //     return view('users.story.edit', [
    //         'story' => $story,
    //         'mediaType' => $story->media_type,
    //         'mediaPath' => $story->media_path,
    //     ]);
        
        
    // }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'media' => 'required|file|max:20480',
    //     ]);

    //     $file = $request->file('media');
    //     $mime = $file->getMimeType();

    //     if (Str::startsWith($mime, 'image/')) {
    //         $mediaType = 'image';
    //         $path = $file->store('stories/temp/images', 'public');
    //     } elseif (Str::startsWith($mime, 'video/')) {
    //         $mediaType = 'video';
    //         $path = $file->store('stories/temp/videos', 'public');
    //     } else {
    //         abort(400, 'Invalid media type');
    //     }

    //     // save to DB here...

    //     return redirect()->route('story.edit', $id);
    // }


    public function store(Request $request)
    {
        $request->validate([
            'media_path' => 'required|string',
            'media_type' => 'required|in:image,video',
            'text'       => 'nullable|string|max:255',
        ]);

        Story::create([
            'user_id'    => Auth::id(),
            'media_path' => $request->media_path,
            'media_type' => $request->media_type,
            'text'       => $request->text,
            'expires_at' => Carbon::now()->addHours(24),
        ]);

        return redirect()->route('index');
    }
}
