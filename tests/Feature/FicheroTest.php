<?php

namespace Tests\Feature;

use App\Models\Fichero;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FicheroTest extends TestCase
{
    /**
     * test Fichero methods
     *
     * @return void
     */

    use RefreshDatabase;
    /** @test*/
    function test_can_get_all_ficheros()
    {
        $fichero = Fichero::factory(4)->create();
        $this->getJson(route('ficheros.index'))
            ->assertJsonFragment([
                'title' => $fichero[0]->description
            ])->assertJsonFragment([
                'title' => $fichero[1]->description
            ]);
    }

    function test_can_get_one_fichero()
    {
        $fichero = Fichero::factory()->create();
        $this->getJson(route('ficheros.show',$fichero))
            ->assertJsonFragment([
                'title' => $fichero->description
            ]);
    }

    function test_can_create_ficheros()
    {

        $this->postJson(route('ficheros.store'),
            [])->assertJsonValidationErrorFor('title');

        $this->postJson(route('ficheros.store'),[
            'title' => 'My Libro'
        ])->assertJsonFragment([
            'title' => 'My Libro'
        ]);

        $this->assertDatabaseHas('ficheros',[
            'title' => 'My Libro'
        ]);
    }

    function test_can_update_ficheros()
    {

        $fichero = Fichero::factory()->create();

        $this->patchJson(route('ficheros.update',$fichero),
            [])->assertJsonValidationErrorFor('title');
        $this->patchJson(route('ficheros.update',$fichero),[
            'title' => 'My Libro'
        ])->assertJsonFragment([
            'title' => 'My Libro'
        ]);

        $this->assertDatabaseHas('ficheros',[
            'title' => 'My Libro'
        ]);
    }

    function test_can_delete_ficheros()
    {
        $fichero = Fichero::factory()->create();
        $this->deleteJson(route('ficheros.update',$fichero))->assertNoContent();
        $this->assertDatabaseCount('ficheros',0);

    }
}
