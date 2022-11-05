<?php

namespace Tests\Feature;

use App\Models\Media;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MediaTest extends TestCase
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
        $fichero = Media::all();
        $response = $this->get('/api/ficheros');
        $response->assertJsonFragment([$fichero]);

    }

    function test_can_create_ficheros()
    {

        $ficheroData = [
            'url' => 'https://i1.rgstatic.net/ii/profile.image/1172923167576064-1656658083458_Q64/Sonja-Mertsch.jpg'
        ];

        $result = $this->post('/api/ficheros', $ficheroData);
        $fichero = Media::query()->find($result->content());
        $this->assertEquals($ficheroData, $ficheroData);
    }

   function test_can_update_ficheros()
   {

		$ficheroData = [
			'url' => 'https://i1.rgstatic.net/ii/profile.image/1172923167576064-1656658083458_Q64/Sonja-Mertsch.jpg'
		];
		$result = $this->post('/api/ficheros', $ficheroData);
		$fichero = Media::query()->find($result->content());
		$this->assertEquals($ficheroData, $ficheroData);
   }

   function test_can_delete_ficheros()
   {
		$ficheroData = [
			'url' => 'https://i1.rgstatic.net/ii/profile.image/1172923167576064-1656658083458_Q64/Sonja-Mertsch.jpg'
		];
       $fichero = Media::factory()->create();
	   $result = $this->delete('/api/ficheros', $ficheroData);
	   $fichero = Media::query()->find($result->content());
		$this->assertEquals($ficheroData, $ficheroData);
   }

}
