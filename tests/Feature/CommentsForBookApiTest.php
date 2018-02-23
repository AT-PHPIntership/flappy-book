<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Faker\Factory as Faker;
use App\Model\Book;
use App\Model\User;
use App\Model\Category;
use App\Model\Comment;

class CommentsForBookApiTest extends TestCase
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
        $response = $this->json('GET', 'api/books/'. $bookId . '/comments');
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
        $response = $this->json('GET', 'api/books/'. $bookId . '/comments');
        $response->assertJsonStructure([
            'meta' => [
                'status',
                'code'
            ],
            'data' => [
                [
                    'id',
                    'comment',
                    'name',
                    'team',
                    'avatar_url',
                    'is_admin',
                    'parent_id',
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
        $response = $this->json('GET', 'api/books/'. $bookId . '/comments');
        $data = json_decode($response->getContent())->data;
        foreach ($data as $comment) {
            $arrayCompare = [
                'id' => $comment->id,
                'comment' => $comment->comment,
                'parent_id' => $comment->parent_id,
            ];
            $this->assertDatabaseHas('comments', $arrayCompare);
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
        $response = $this->json('GET', 'api/books/'. $bookId . '/comments?page=2');
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

        $users = factory(User::class, 2)->create();
        $employCodes = $users->pluck('employ_code')->toArray();
        $userIds = $users->pluck('id')->toArray();

        $categoryIds = factory(Category::class, 2)->create()->pluck('id')->toArray();

        $bookId = factory(Book::class)->create([
            'category_id' => $faker->randomElement($categoryIds),
            'from_person' => $faker->randomElement($employCodes)
        ])->id;

        $comments = factory(Comment::class, $row)->create([
            'user_id' => $faker->randomElement($userIds),
            'commentable_id' => $bookId,
            'commentable_type' => 'book',
        ]);

        return $bookId;
    }
}
