<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Model\User;
use Illuminate\Http\Response;

class ApiGetInfoUserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Return json structure of infomation user
     *
     * @return array
     */
    public function JsonStructureInfoUser()
    {
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
            ],
        ];
    }

    /**
     * Test compare structure of json.
     *
     * @return void
     */
    public function testJsonStructureInfoUser()
    {
        factory(User::class)->create();
        $response = $this->json('GET', '/api/users/1');
        $response->assertJsonStructure($this->JsonStructureInfoUser());
    }

    /**
     * Test meta api get info user ís success
     *
     * @return void
     */
    public function testGetInfoUserSuccess()
    {
        factory(User::class)->create();
        $response = $this->get('/api/users/1');
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'meta' => [
                    'status' => 'Successfully',
                ],
            ]);
    }

    /**
     * Test compare database.
     *
     * @return void
     */
    public function testCompareDatabase(){
        factory(User::class)->create();
        $response = $this->json('GET', '/api/users/1');
        $data = json_decode($response->getContent());
        $this->assertDatabaseHas('users', [
            'id' => $data->data->id,
            'employ_code' => $data->data->employ_code,
            'name' => $data->data->name,
            'team' => $data->data->team,
            'email' => $data->data->email,
            'is_admin' => $data->data->is_admin,
            'avatar_url' => $data->data->avatar_url
        ]);
    }

    /**
     * Test get info user fail
     *
     * @return void
     */
    public function testGetInfoUserFail()
    {
        $response = $this->get('/api/users/1');
        $response->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson([
                'meta' => [
                    'status' => 'Failed',
                ],
            ]);
    }
}
