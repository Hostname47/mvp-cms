<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Role;

class RoleTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create_a_role() {
        $this->assertCount(0, Role::all());
        $this->post('/admin/roles', ['title'=>'Admin','slug'=>'admin','description'=>'admin description']);
        $this->assertCount(1, Role::all());
    }

    /** @test */
    public function create_a_role_validation() {
        Role::create(['title'=>'Admin','slug'=>'admin','description'=>'admin description']);
        $this->post('/admin/roles', [
            'title'=>'Admin','slug'=>'admin','description'=>'admin description'
        ])->assertRedirect()->assertSessionHasErrors(['title','slug']); // Role already exists with that title and slug

        $this->post('/admin/roles', [
            'title'=>'Author','description'=>'author description'
        ])->assertRedirect()->assertSessionHasErrors(['slug']); // slug field is required
    }
}
