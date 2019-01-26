<?php

namespace App\Functional\Api\V1\Controllers;

use Hash;
use App\User;
use App\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;

class UserControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $user = new User([
            'name' => 'Test',
            'email' => 'test@email.com',
            'password' => '123456'
        ]);

        $user->save();
    }

    public function testMe()
    {
        $response = $this->post('api/auth/login', [
            'email' => 'test@email.com',
            'password' => '123456'
        ]);

        $response->assertStatus(200);

        $responseJSON = json_decode($response->getContent(), true);
        $token = $responseJSON['token'];

        $this->get('api/me?token=' . $token, [], [])->assertJson([
            'name' => 'Test',
            'email' => 'test@email.com'
        ])->isOk();
    }

    public function testUpdate()
    {
        $response = $this->post('api/auth/login', [
            'email' => 'test@email.com',
            'password' => '123456'
        ]);

        $response->assertStatus(200);

        $responseJSON = json_decode($response->getContent(), true);
        $token = $responseJSON['token'];

        $responseMe = $this->get('api/me?token=' . $token, [], []);
        $oldData = $responseMe->json();

        $responseUpdate = $this->post('api/update', [
            'name' => 'Test Edited',
            'costume_name' => 'Costume Name Edited',
            'photo' => UploadedFile::fake()->image('random.jpg'),
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $responseMe = $this->get('api/me?token=' . $token, [], []);
        $user = $responseMe->json();

        $responseMe->assertJson([
            'name' => 'Test Edited',
            'costume' => [
                'name' => 'Costume Name Edited',
                'photo' => $user['costume']['photo']
            ],
        ])->isOk();

        $responseUpdate->assertStatus(200);

        $this->assertTrue($user['name'] !== $oldData['name']);
        $this->assertTrue($user['costume']['name'] !== $oldData['costume']['name']);
        $this->assertTrue($user['costume']['photo'] !== $oldData['costume']['photo']);
    }
}
