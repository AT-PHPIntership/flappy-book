<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Model\Book;
use App\Model\User;
use App\Model\Category;
use App\Model\Post;
use App\Model\Rating;
use Faker\Factory as Faker;

class postsForBookApiTest extends TestCase
{
    /**
     * test status response
     *
     * @return void
     */
    public function testStatusCode()
    {
        $response = $this->json('GET', 'api/books/1/posts');
        $response->assertStatus(200);
    }

    /**
     * Test struct json.
     *
     * @return void
     */
    public function testStructJson()
    {
        $books_id = $this->makeData(2);
        $response = $this->json('GET', 'api/books/'. $books_id . '/posts');
        $response->assertJsonStructure([
            'meta' => [
                'status',
                'code'
            ],
            'data' => [
                [
                    'id',
                    'content',
                    'name',
                    'team',
                    'avatar_url',
                    'rating',
                    'likes',
                    'created_at',
                    'updated_at',
                    'deleted_at',
                ],
            ],
            'pagination' => [
                'total',
                'per_page',
                'current_page',
                'total_pages',
                'links' => [
                    'prev',
                    'next'
                ]
            ],
        ]);
        $response->assertStatus(200);
    }

     /**
     * Test check some object compare database.
     *
     * @return void
     */
    public function testCompareDatabase()
    {
        $books_id = $this->makeData(2);
        $response = $this->json('GET', 'api/books/'. $books_id . '/posts');
        $data = json_decode($response->getContent())->data;
        foreach ($data as $post) {
            $arrayCompare = [
                'id' => $post->id,
                'content' => $post->content,
            ];
            $this->assertDatabaseHas('posts', $arrayCompare);
        }
    }

    /**
     * Test result pagination.
     *
     * @return void
     */
    public function testGetPaginationResult()
    {
        $books_id = $this->makeData(15);
        $response = $this->json('GET', 'api/books/'. $books_id . '/posts?page=2');
        $response->assertJson([
            'pagination' => [
                'total' => 15,
                'per_page' => 10,
                'current_page' => 2,
                'total_pages' => 2,
            ]
        ]);
        $response->assertStatus(200);
    }

    /**
    * Make data for test.
    *
    * @return void
    */
    public function makeData($row)
    {
        $faker = Faker::create();

        $users = factory(User::class)->create();

        $categories = factory(Category::class)->create();

        $books = factory(Book::class)->create([
            'category_id' => $categories->id,
            'from_person' => $users->employ_code,
        ]);

        $posts = factory(Post::class, $row)->create([
            'user_id' => $users->id,
        ]);

        foreach ($posts as $post) {
            factory(Rating::class)->create([
                'post_id' => $post->id,
                'book_id' => $books->id
            ]);
        }

        return $books->id;
    }
}
