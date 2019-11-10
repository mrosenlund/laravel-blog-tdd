<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function store()
    {
        $post = Post::create($this->validateRequest());

        return redirect($post->path());
    }

    public function update(Post $post)
    {
        $post->update($this->validateRequest());

        return redirect($post->path());
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect('/posts');
    }

    protected function validateRequest()
    {
        return request()->validate([
            'title'     =>  'required',
            'body'      =>  'required',
        ]);
    }
}
