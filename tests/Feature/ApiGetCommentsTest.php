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
use App\Model\Post;

class ApiGetCommentsTest extends TestCase
{
    use DatabaseMigrations;

    const COMMENTABLE_ID = 1;

    protected function setUp()
    {
        parent::setUp();
        $this->makeData(15);
    }

    /**
     * Make cases test add comment for book or post.
     *
     * @return array
     */
    public function commentableType()
    {
        return [
            [Comment::BOOK_TYPE],
            [Comment::POST_TYPE]
        ];
    }

    /**
     * test status response
     *
     * @dataProvider commentableType
     *
     * @return void
     */
    public function testStatusCode($commentableType)
    {
        $request = [
            'commentable_id' => self::COMMENTABLE_ID,
            'commentable_type' => $commentableType
        ];

        $response = $this->json('GET', 'api/comments', $request);
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test struct json.
     *
     * @dataProvider commentableType
     *
     * @return void
     */
    public function testStructJson($commentableType)
    {
        $request = [
            'commentable_id' => self::COMMENTABLE_ID,
            'commentable_type' => $commentableType
        ];

        $response = $this->json('GET', 'api/comments', $request);
        $response->assertJsonStructure([
            'meta' => [
                'status',
                'code'
            ],
            'data' => [
                [
                    'id',
                    'comment',
                    'commentable_id',
                    'commentable_type',
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
     * @dataProvider commentableType
     *
     * @return void
     */
    public function testCompareDatabase($commentableType)
    {
        $request = [
            'commentable_id' => self::COMMENTABLE_ID,
            'commentable_type' => $commentableType
        ];

        $response = $this->json('GET', 'api/comments', $request);
        $comments = json_decode($response->getContent())->data;
        foreach ($comments as $comment) {
            $arrayCompare = [
                'id' => $comment->id,
                'comment' => $comment->comment,
                'commentable_id' => $comment->commentable_id,
                'commentable_type' => $comment->commentable_type,
                'parent_id' => $comment->parent_id,
            ];
            $this->assertDatabaseHas('comments', $arrayCompare);
        }
    }

    /**
     * Test result pagination.
     *
     * @dataProvider commentableType
     *
     * @return void
     */
    public function testGetPaginationResult($commentableType)
    {
        $request = [
            'commentable_id' => self::COMMENTABLE_ID,
            'commentable_type' => $commentableType
        ];

        $response = $this->json('GET', 'api/comments?page=2', $request);
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
     * Make cases test validate add comment.
     *
     * @return array
     */
    public function validateDataTest()
    {
        return [
            ['commentable_id', '', 'The commentable id field is required.'],
            ['commentable_id', 'abc', 'The commentable id must be an integer.'],
            ['commentable_type', '', 'The commentable type field is required.'],
            ['commentable_type', 'abc', 'The selected commentable type is invalid.']
        ];
    }

    /**
     * Test result pagination.
     *
     * @dataProvider validateDataTest
     *
     * @return void
     */
    public function testValidateRequest($field, $content, $message)
    {
        $request[$field] = $content;

        $response = $this->json('GET', 'api/comments', $request);
        $response->assertJson([
            'error' => [
                'message' => [
                    $field => [
                        $message,
                    ]
                ],
            ]
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
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
        ]);

        $postId = factory(Post::class)->create([
            'user_id' => $faker->randomElement($userIds),
        ]);

        factory(Comment::class, $row)->create([
            'user_id' => $faker->randomElement($userIds),
            'commentable_id' => self::COMMENTABLE_ID,
            'commentable_type' => Comment::BOOK_TYPE,
        ]);

        factory(Comment::class, $row)->create([
            'user_id' => $faker->randomElement($userIds),
            'commentable_id' => self::COMMENTABLE_ID,
            'commentable_type' => Comment::POST_TYPE,
        ]);
    }
}
