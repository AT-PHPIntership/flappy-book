<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;
use App\Model\Category;
use Illuminate\Http\Response;

class ApiListCategoriesTest extends TestCase
{
    use DatabaseMigrations;

    const NUMBER_RECORD_CREATE = 5;

    /**
     * Receive status code 200 when get list categories success.
     *
     * @return void
     */
    public function testStatusCodeSuccess()
    {
        factory(Category::class)->create();
        $response = $this->json('GET', '/api/categories');
        $response->assertStatus(Response::HTTP_OK);
    }
    /**
     * Return structure of json.
     *
     * @return array
     */
    public function jsonStructureListCategories()
    {
        return [
            'meta' => [
                'status',
                'code'
            ],
            'data' => [
                [
                    'id',
                    'title'
                ]
            ]    
        ];
    }
    /**
     * Test structure of json response.
     *
     * @return void
     */
    public function testJsonListCategories()
    {
        factory(Category::class, self::NUMBER_RECORD_CREATE)->create();
        $response = $this->json('GET', '/api/categories');
        $response->assertJsonStructure($this->jsonStructureListCategories());
    }
    /**
     * Test compare database
     * 
     * @return void
     */
    public function testCompareDatabase()
    {
        factory(Category::class, self::NUMBER_RECORD_CREATE)->create();
        $response = $this->json('GET', '/api/categories');
        $data = json_decode($response->getContent());
        $arrayCompare = [
            'id' => $data->data[0]->id,
            'title' => $data->data[0]->title
        ];
        $this->assertDatabaseHas('categories', $arrayCompare);
        $this->assertTrue(count($data->data) === self::NUMBER_RECORD_CREATE);
    }
    /**
     * Test structure of json when empty categories.
     *
     * @return void
     */
    public function testEmptyCategories()
    {
        $response = $this->json('GET', '/api/categories');   
        $response->assertJson([
            'data' => []
        ]);
    }
}
