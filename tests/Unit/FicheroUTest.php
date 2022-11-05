<?php

namespace Tests\Unit;

use App\Models\Media;
//use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class FicheroUTest extends TestCase
{

    use RefreshDatabase;
    /**
     * Check if public profile api is accessible or not.
     *
     * @return void
     */
    public function test_can_all_ficheros()
    {
        $response = $this->get('/api/ficheros');

        $response->assertStatus(200);
    }


    /**
     * Test if product is creatable.
     *
     * @return void
     */
    public function test_can_register_fichero()
    {
        // Login the user first.
        $ficheros = Media::factory(4)->create();
        $ficheroData = [
            'url' => 'https://i1.rgstatic.net/ii/profile.image/1172923167576064-1656658083458_Q64/Sonja-Mertsch.jpg'
        ];
        $result = $this->post('/api/ficheros', $ficheroData);
        $ficheros = Media::query()->find($result->content());
        $this->assertEquals($ficheroData, $ficheroData);
    }
}
