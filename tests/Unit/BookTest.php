<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTest extends TestCase
{
    /**
     * Test response Api detail book
     *
     * @return void
     */
    public function testDetailBook()
    {
        $response = $this->get('/api/books/1');
        $response->assertStatus(200)
                ->assertJson([
                    'meta' => [
                        'status' => 'successfully',
                    ],
                ])
                ->assertJsonStructure([
                    'data' => [
                        'id',
                        'title',
                        'category_id',
                        'description',
                        'language',
                        'rating',
                        'total_rating',
                        'picture',
                        'author',
                        'price',
                        'unit',
                        'year',
                        'page_number',
                        'status',
                        'user_id',
                        'donator',
                        'category',
                    ]
                ]);
    }

    /**
     * Test response Api get book does not exist
     *
     * @return void
     */
    public function testGetBookDoesNotExist()
    {
        $response = $this->get('/api/books/0');
        $response->assertStatus(404)
                ->assertJson([
                    'meta' => [
                        'status' => 'failed'
                    ],
                ]);
    }
}
