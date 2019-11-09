<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Post;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test  **/
    public function new_post_created()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/posts', [
                        'title'     =>  'New Blog Post Title',
                        'body'      =>  'New blog post body text',
                        'posted_at' =>  date("Y-m-d H:i:s")
                     ]);

        $response->assertOk();
        $this->assertCount(1, Post::all());
    }

    /** @test **/
    public function a_title_is_required()
    {
        $response = $this->post('/posts', [
            'title'     =>  '',
            'body'      =>  'New blog post body text'
        ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test **/
    public function a_body_is_required()
    {
        $response = $this->post('/posts', [
            'title'     =>  'New Blog Post Title',
            'body'      =>  ''
        ]);

        $response->assertSessionHasErrors('body');
    }

    /** @test **/
    public function a_post_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->post('/posts', [
            'title'     =>  'New Blog Post Title',
            'body'      =>  'New blog post body text',
            'posted_at' =>  date("Y-m-d H:i:s")
        ]);

        $post = Post::first();

        $response = $this->patch('/posts/' . $post->id, [
            'title' => 'New Title',
            'body'  =>  'New Body'
        ]);

        $this->assertEquals('New Title', Post::first()->title);
        $this->assertEquals('New Body', Post::first()->body);
    }
}
