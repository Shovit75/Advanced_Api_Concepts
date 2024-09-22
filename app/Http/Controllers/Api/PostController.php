<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(){
        $posts = Post::all();
        if($posts->count() == 0){
            return response()->json([
                'message' => 'No Posts Found.'
            ], 404);
        }
        return response()->json([
            'message' => 'All Posts Found',
            'posts' => $posts
        ], 200);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|max:500',
            'user_id' => 'required|exists:users,id',
            'multipleimage.*' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);
        $imagePaths = [];
        if($request->hasFile('multipleimage')){
            foreach($request->file('multipleimage') as $image){
                $path = $image->store('images', 'public');
                $imagePaths[] = $path;
            }
        }
        $post = new Post;
        $post -> name = $request['name'];
        $post -> description = $request['description'];
        $post -> multipleimage = $imagePaths;
        $post -> user_id = $request['user_id'];
        $post -> save();
        return response()->json([
            'message' => 'Post Created Successfully.',
            'post' => $post
        ], 201);
    }

    public function show($id){
        $post = Post::find($id);
        if($post){
            return response()->json([
                'message' => 'Post Found',
                'post' => $post,
            ], 200);
        }
        return response()->json([
            'message' => 'Post not found',
        ], 404);
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|max:500',
            'user_id' => 'required|exists:users,id',
            'multipleimage.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);
        $post = Post::find($id);
        if($post){
            $imagepaths = [];
            if($request->hasFile('multipleimage')){
                if ($post->multipleimage) {        
                    foreach ($post->multipleimage as $img) {
                        \Storage::disk('public')->delete($img);
                    }
                }
                foreach($request->file('multipleimage') as $image){
                    $path = $image->store('images', 'public');
                    $imagepaths[] = $path;
                }
            }
            $post->update([
                'name' => $request['name'],
                'description' => $request['description'],
                'user_id' => $request['user_id'],
                'multipleimage' => $imagepaths
            ]);
            return response()->json([
                'message' => 'Post updated successfully',
                'post' => $post
            ], 201);
        }
        return response()->json([
            'message' => 'Post not found',
        ], 404);
    }

    public function delete(Request $request, $id){
        $post = Post::find($id);
        if($post){
            if($post->multipleimage){
                $images = $post->multipleimage;
                foreach($images as $imgs){
                    \Storage::disk('public')->delete($imgs);
                }
            }
            $post->delete();
            return response()->json([
                'message' => 'Post deleted successfully',
            ], 200);
        }
        return response()->json([
            'message' => 'No user found',
        ], 404);
    }
}
