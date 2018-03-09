<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Faker\Factory as Faker;
use App\Model\Book;
use App\Model\User;
use App\Model\Category;
use App\Model\Post;
use App\Model\Rating;
use App\Model\Language;

class ApiGetReviewsForBookTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * test status response
     *
     * @return void
     */
    public function testStatusCode()
    {
        $bookId = $this->makeData(1);
        $response = $this->json('GET', 'api/books/' . $bookId . '/reviews');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test struct json.
     *
     * @return void
     */
    public function testStructJson()
    {
        $bookId = $this->makeData(2);
        $response = $this->json('GET', 'api/books/'. $bookId . '/reviews');
        $response->assertJsonStructure([
            'meta' => [
                'status',
                'code'
            ],
            'data' => [
                [
                    'id',
                    'user_id',
                    'content',
                    'status',
                    'created_at',
                    'updated_at',
                    'like' => [
                        'likes',
                    ],
                    'user' => [
                        'id',
                        'name',
                        'team',
                        'avatar_url',
                        'is_admin',
                    ],
                    'rating' => [
                        'id',
                        'post_id',
                        'book_id',
                        'rating'
                    ],
                ],
            ],
            'pagination' => [
                'total',
                'per_page',
                'current_page',
                'total_pages',
                'links'
            ],
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }

     /**
     * Test check some object compare database.
     *
     * @return void
     */
    public function testCompareDatabase()
    {
        $bookId = $this->makeData(2);
        $response = $this->json('GET', 'api/books/'. $bookId . '/reviews');
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
        $bookId = $this->makeData(15);
        $response = $this->json('GET', 'api/books/'. $bookId . '/reviews?page=2');
        $response->assertJson([
            'pagination' => [
                'total' => 15,
                'per_page' => 10,
                'current_page' => 2,
                'total_pages' => 2,
            ]
        ]);
        $response->assertStatus(Response::HTTP_OK);
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

        $language = factory(Language::class)->create([
            'language' =>  $faker->randomElement(Language::LANGUAGES),
        ]);

        $books = factory(Book::class)->create([
            'category_id' => $categories->id,
            'language_id' => $language->id,
            'from_person' => $users->employ_code,
        ]);

        $posts = factory(Post::class, $row)->create([
            'user_id' => $users->id,
            'status' => Post::TYPE_REVIEW_BOOK
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
