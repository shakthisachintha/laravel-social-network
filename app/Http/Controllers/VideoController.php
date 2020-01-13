<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
        ini_set('upload_max_filesize', '300M');
        ini_set('post_max_size', '350M');
    }


    public function index(Request $request){
        $user = Auth::user();
        return view('videos.index', compact('user'));
    }


    public function upload(Request $request){
        
        $content=$request->content;
        $path = $request->file('video')->store('public/videos');
        
        $user=Auth::user();

        $post=new Post();
        $post->user_id=$user->id;
        $post->has_video=1;
        $post->has_image=1;
        $post->group_id=0;
        
        if($content){
            $post->content=$content;
        }

        $post->save();

        $post_image=new PostImage();
        $post_image->post_id=$post->id;
        $post_image->image_path=basename($path);
        $post_image->save();

        return response()->json([
            "code"=>200,
            "path"=>basename($path),
            "content"=>$content,
        ]);
    }

}
