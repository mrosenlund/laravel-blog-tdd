<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function store()
    {
        Post::create($this->validateRequest());
    }

    public function update(Post $post)
    {
        $post->update($this->validateRequest());
    }

    protected function validateRequest()
    {
        return request()->validate([
            'title'     =>  'required',
            'body'      =>  'required',
        ]);
    }
}
