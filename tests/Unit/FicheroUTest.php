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
     * A basic unit test example.
     *
     * @return void
     */
    public function test_list_ficheros()
    {
        $response  = $this->get('/api/ficheros');
//        $response->assertStatus(200);
    }

    public function test_register_ficheros()
    {

        $urlData = [
            'url' => 'Ford'
        ];

        $result = $this->post('/api/ficheros', $urlData);

        $fichero = Media::query()->find($result->content());
        $this->assertNotNull($fichero);
        $this->assertEquals($urlData, $fichero->only(['url']));
    }
}
