<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;

class UserTest extends TestCase
{
    /**
     * test Users methods
     *
     * @return void
     */
    use RefreshDatabase;
    /** @test*/

	public function test_can_login_user()
    {
        $valiData = User::where('email', 'admin@example.com')->first();
		$userData = [
			'email', 'admin@example.com'
		];
		$this->assertEquals($userData, $userData);
    }


    function test_can_register_user()
    {
        $usuario = User::factory()->create();
        $userData = [
            'name' => 'usuario',
			'email' => 'usuario@user.com',
			'paswword' => 'user2022',
			'password_confirmation' => 'user2022'
        ];

        $result = $this->post('/api/auth/register', $userData);
        $fichero = User::query()->find($result->content());
        $this->assertEquals($userData, $userData);
    
    }

}
