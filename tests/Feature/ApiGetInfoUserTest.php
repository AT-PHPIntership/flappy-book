<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Model\User;
use Illuminate\Http\Response;

class ApiGetInfoUserTest extends TestCase
{
    use DatabaseMigrations;

    const NUMBER_RECORD_CREATE = 5;

    /**
     * Receive status code 200 when get infomation of user success.
     *
     * @return void
     */
    public function testStatusCodeSuccess()
    {
        factory(User::class, self::NUMBER_RECORD_CREATE)->create();
        $this->app->instance('middleware.disable', true);
        $response = $this->json('GET', '/api/users/1');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Return structure of json.
     *
     * @return array
     */
    public function jsonStructureInfoUser(){
        return [
            'meta' => [
                'status',
                'code'
            ],
            'data' => [
                'id',
                'employ_code',
                'name',
                'team',
                'email',
                'is_admin',
                'avatar_url',
                'book_borrowing',
                'donated',
                'borrowed'
            ]    
        ];
    }

    /**
     * Test structure of json response.
     *
     * @return void
     */
    public function testJsonInfoUserStructure(){
        factory(User::class, self::NUMBER_RECORD_CREATE)->create();
        $this->app->instance('middleware.disable', true);
        $response = $this->json('GET', '/api/users/1');
        $response->assertJsonStructure($this->jsonStructureInfoUser());
    }

    /**
     * Test compare database
     * 
     * @return void
     */
    public function testCompareDatabase()
    {
        factory(User::class, self::NUMBER_RECORD_CREATE)->create();
        $this->app->instance('middleware.disable', true);
        $response = $this->json('GET', '/api/users/1');
        $data = json_decode($response->getContent());
        $arrayCompare = [
            'id' => $data->data->id,
            'employ_code' => $data->data->employ_code,
            'name' => $data->data->name,
            'email' => $data->data->email,
            'is_admin' => $data->data->is_admin,
            'avatar_url' => $data->data->avatar_url,
        ];
        $this->assertDatabaseHas('users', $arrayCompare);
    }

    /**
     * Test User doesn't exist
     *
     * @return void
     */
    public function testUserDoesNotExist()
    {
        $this->app->instance('middleware.disable', true);
        $response = $this->get('/api/users/0');
        $response->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson([
                'meta' => [
                    'status' => 'Failed'
                ],
            ]);
    }

    /**
     * test Get information of user when unauthorized
     *
     * @return void
     */
    public function testUnauthorized()
    {
        factory(User::class, self::NUMBER_RECORD_CREATE)->create();        
        $response = $this->get('/api/users/1');
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJson([
                'meta' => [
                    'status' => 'Failed'
                ],
            ]);
    }
}
