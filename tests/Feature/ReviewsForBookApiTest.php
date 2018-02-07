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

class ReviewsForBookApiTest extends TestCase
{
    /**
     * test status code
     *
     * @return void
     */
    public function testStatusCode()
    {
        $books_id = $this->makeData(5);
        $response = $this->json('GET', 'api/books/'. $books_id . '/reviews');
        $response->assertStatus(200);
    }

    /**
     * Test struct json.
     *
     * @return void
     */
    public function testStructJson()
    {
        $books_id = $this->makeData(5);
        $response = $this->json('GET', 'api/books/'. $books_id . '/reviews');
        $response->assertJsonStructure([
                'meta' => [
                	'status',
                	'code'
                ],
                'data' => [
                    'id',
	                'content',
	                'name',
	                'team',
	                'avatar_url',
	                'rating',
	                'likes',
	                'create_date'
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
            factory(Rating::class, $row)->create([
                'post_id' => $post->id,
                'book_id' => $books->id
            ]);
        }

        return $books->id;
    }
}
