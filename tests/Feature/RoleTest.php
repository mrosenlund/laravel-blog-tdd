<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Role;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test  **/
    public function new_role_created()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/roles', [
            'name'  =>  'admin'
        ]);

        $role = Role::first();

        $this->assertCount(1, Role::all());
        $response->assertRedirect('/roles/' . $role->id);
    }

    /** @test **/
    public function a_name_is_required()
    {
        $response = $this->post('/roles', [
            'name'     =>  '',
        ]);

        $response->assertSessionHasErrors('name');
    }

    /** @test **/
    public function a_role_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->post('/roles', [
            'name'  => 'admin'
        ]);

        $role = Role::first();

        $response = $this->patch('/roles/' . $role->id, [
            'name'  => 'new admin'
        ]);

        $this->assertEquals('new admin', Role::first()->name);
        $response->assertRedirect('/roles/' . $role->id);
    }


    /** @test **/
    public function a_role_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $this->post('/roles', [
            'name'  =>  'admin'
        ]);

        $role = Role::first();
        $this->assertCount(1, Role::all());

        $response = $this->delete('/roles/' . $role->id);

        $this->assertCount(0, Role::all());
        $response->assertRedirect('/roles');
    }
}
