<?php

namespace Tests\Feature;

use App\Models\Media;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FicheroTest extends TestCase
{
    /**
     * test Media methods
     *
     * @return void
     */

    use RefreshDatabase;
    /** @test*/
    function test_can_get_all_ficheros()
    {
        $fichero = Media::factory(4)->create();
//        $this->get('/api/ficheros')->getContent();
        $this->getJson('/api/ficheros');
            ->assertJsonFragment([
                'url' => $fichero->url
            ]);
    }

//    function test_can_get_one_fichero()
//    {
//        $fichero = Media::factory()->create();
//        $this->getJson(route('ficheros.show',$fichero))
//            ->assertJsonFragment([
//                'title' => $fichero->description
//            ]);
//    }
//
//    function test_can_create_ficheros()
//    {
//
//        $this->postJson(route('ficheros.store'),
//            [])->assertJsonValidationErrorFor('title');
//
//        $this->postJson(route('ficheros.store'),[
//            'title' => 'My Libro'
//        ])->assertJsonFragment([
//            'title' => 'My Libro'
//        ]);
//
//        $this->assertDatabaseHas('ficheros',[
//            'title' => 'My Libro'
//        ]);
//    }
//
//    function test_can_update_ficheros()
//    {
//
//        $fichero = Media::factory()->create();
//
//        $this->patchJson(route('ficheros.update',$fichero),
//            [])->assertJsonValidationErrorFor('title');
//        $this->patchJson(route('ficheros.update',$fichero),[
//            'title' => 'My Libro'
//        ])->assertJsonFragment([
//            'title' => 'My Libro'
//        ]);
//
//        $this->assertDatabaseHas('ficheros',[
//            'title' => 'My Libro'
//        ]);
//    }
//
//    function test_can_delete_ficheros()
//    {
//        $fichero = Media::factory()->create();
//        $this->deleteJson(route('ficheros.update',$fichero))->assertNoContent();
//        $this->assertDatabaseCount('ficheros',0);
//
//    }
}
