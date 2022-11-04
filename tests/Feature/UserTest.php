<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * test Users methods
     *
     * @return void
     */
    use RefreshDatabase;
    /** @test*/
    function test_can_get_all_users()
    {
        $usuario = User::factory(4)->create();
        $this->getJson(route('users.index'))
            ->assertJsonFragment([
                'title' => $usuario[0]->name
            ])->assertJsonFragment([
                'title' => $usuario[1]->name
            ]);
    }

    function test_can_get_one_user()
    {
        $usuario = User::factory()->create();
        $this->getJson(route('users.show',$usuario))
            ->assertJsonFragment([
                'title' => $usuario->name
            ]);
    }

    function test_can_create_users()
    {

        $this->postJson(route('users.store'),
            [])->assertJsonValidationErrorFor('title');

        $this->postJson(route('users.store'),[
            'title' => 'My Libro'
        ])->assertJsonFragment([
            'title' => 'My Libro'
        ]);

        $this->assertDatabaseHas('users',[
            'title' => 'My Libro'
        ]);
    }

    function test_can_update_users()
    {

        $usuario = User::factory()->create();

        $this->patchJson(route('users.update',$usuario),
            [])->assertJsonValidationErrorFor('title');
        $this->patchJson(route('users.update',$usuario),[
            'title' => 'My Libro'
        ])->assertJsonFragment([
            'title' => 'My Libro'
        ]);

        $this->assertDatabaseHas('users',[
            'title' => 'My Libro'
        ]);
    }

    function test_can_delete_users()
    {
        $usuario = User::factory()->create();
        $this->deleteJson(route('users.update',$usuario))->assertNoContent();
        $this->assertDatabaseCount('users',0);

    }
}
