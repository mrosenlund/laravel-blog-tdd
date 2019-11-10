<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function new_category_created()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/categories', [
            'name'  => 'new categigory'
        ]);

        $category = Category::first();

        $this->assertCount(1, Category::all());
        $response->assertRedirect('/categories/' . $category->id);
    }

    /** @test **/
    public function a_name_is_required()
    {
        $response = $this->post('/categories', [
            'name'  => ''
        ]);

        $response->assertSessionHasErrors('name');
    }

    /** @test **/
    public function a_category_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->post('/categories', [
            'name'  => 'new category'
        ]);

        $category = Category::first();

        $response = $this->patch('/categories/' . $category->id, [
            'name' => 'New Name'
        ]);

        $this->assertEquals('New Name', Category::first()->name);
        $response->assertRedirect('/categories/' . $category->id);
    }

    /** @test **/
    public function a_category_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $this->post('/categories', [
            'name'  => 'new category'
        ]);

        $category = Category::first();
        $this->assertCount(1, Category::all());

        $response = $this->delete('/categories/' . $category->id);

        $this->assertCount(0, Category::all());
        $response->assertRedirect('/categories');
    }
}
