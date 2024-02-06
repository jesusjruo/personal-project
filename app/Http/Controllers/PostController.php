<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function createPost(Request $request) {
        if(auth()->user()->id === $post['user_id']) {
            $fields = $request->validate([
                'title' => 'required',
                'body' => 'required'
            ]);
    
            $fields['title'] = strip_tags($fields['title']);
            $fields['body'] = strip_tags($fields['body']);
            $fields['user_id'] = auth()->id();
            Post::create($fields);
        }

        return redirect('/');
    }

    public function showEditScreen(Post $post) {
        if(auth()->user()->id === $post['user_id']) {
            return view('edit-post' , ['post' => $post]);
        }

        return redirect('/');
    }

    public function editPost(Post $post, Request $request) {
        if(auth()->user()->id === $post['user_id']) {
            $fields = $request->validate([
                'title' => 'required',
                'body' => 'required'
            ]);
            
            $fields['title'] = strip_tags($fields['title']);
            $fields['body'] = strip_tags($fields['body']);

            $post->update($fields);
        }

        return redirect('/');
    }

    public function deletePost(Post $post) {
        if(auth()->user()->id === $post['user_id']) {
            $post->delete();
        }

        return redirect('/');
    }
}
