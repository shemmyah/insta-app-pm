<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $post;
    private $user;
    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // $all_posts = $this->post->latest()->get();
        // return view('users.home')->with('all_posts', $all_posts);
        $home_posts = $this->getHomePosts();
        $suggested_users = $this->getSuggestedUsers();
        $file = $request->file('media');
        $mediaType=null;
        $path=null;
   
        if ($file) {
        $mime = $file->getMimeType();

        if (Str::startsWith($mime, 'image/')) {
            $mediaType = 'image';
            $path = $file->store('stories/temp/images', 'public');
        } elseif (Str::startsWith($mime, 'video/')) {
            $mediaType = 'video';
            $path = $file->store('stories/temp/videos', 'public');
        } else {
            abort(400, 'Invalid media type');
        }
    }


        $storyUsers = User::where('id', '!=', Auth::user()->id)
        ->whereHas('stories', function ($query) {
            $query->where('expires_at', '>', now());
        })
        ->with('stories')
        ->get();
        return view('users.home')
                ->with('home_posts', $home_posts)
                ->with('suggested_users', $suggested_users)
                ->with('storyUsers',$storyUsers)
                ->with('mediaType', $mediaType)
                ->with('mediaPath', $path);
                // ->with('hasStory',$hasStory);

    }
    
    // public function create() {
    //     // dd(Auth::user()->id);
    //    return view('users.story.create');
    // }


    #Get the posts of the users that the Auth user is following
    public function getHomePosts() {
        $all_posts = $this->post->latest()->get();
        $home_posts = [];

        foreach($all_posts as $post){
            if($post->user->isFollowed() || $post->user->id === Auth::user()->id){
                $home_posts[] = $post;
            }
        }

        return $home_posts;
    }

    #Get the users that Auth user is not following
    public function getSuggestedUsers() {
        $all_users = $this->user->all()->except(Auth::user()->id);
        $suggested_users = [];

        foreach($all_users as $user){
            if(!$user->isFollowed()){
                $suggested_users[] = $user;
            }
        }

        return $suggested_users;
    }

    public function search(Request $request) {
        $users = $this->user->where('name', 'like', '%'.$request->search.'%')->get();
        return view('users.search')->with('users', $users)->with('search', $request->search);
    }
}
