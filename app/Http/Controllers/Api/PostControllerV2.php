<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\Postgetallv2Resource;
use App\Http\Resources\PostfilterbyrecentResource;

class PostControllerV2 extends Controller
{
    //Advanced concepts of API With Resource to provide a structured way to transform data in API responses ( v2 )

    //Filtering the data to show all the latest created posts
    public function filterlatestposts(Request $request){
        //To show the latest posts created
        $posts = Post::orderBy('created_at', 'desc')->get();
        return PostfilterbyrecentResource::collection($posts);
    }

    //Get images of all posts but rate limiting set to 2 requests per minute
    public function getallpostsimagesratelimiting(Request $request){
        $posts = Post::all();
        return Postgetallv2Resource::collection($posts);
    }
}
