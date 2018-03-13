<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Faker\Factory as Faker;
use App\Model\Book;
use App\Model\User;
use App\Model\Category;
use App\Model\Language;
use App\Model\Comment;

class ApiEditCommentTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Receive status code 404 when not found comment.
     *
     * @return void
     */
    public function testNotFoundComment()
    {
        $response = $this->put('/api/comments/0');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * Return structure of json error validate.
     *
     * @return array
     */
    public function jsonStructureValidateError () {
        return [
            'meta' => [
                'status' => 'Failed',
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY
            ],
            'error' => [
                'message' => [
                    'comment' => [
                        'The comment field is required.'
                    ]
                ]
            ]
        ];
    }

    /**
     * Test validate of request
     *
     * @return void
     */
    public function testValidation()
    {
        $user = $this->makeData(5);
        $this->be($user);
        $this->withoutMiddleware();

        $response = $this->put('/api/comments/1');
        $response->assertJson($this->jsonStructureValidateError())
                 ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Return structure of json.
     *
     * @return array
     */
    public function jsonStructureEditComment () {
        return [
            'meta' => [
                'status',
                'code'
            ],
            'data' => [
                'id',
                'comment',
                'commentable_id',
                'commentable_type',
                'parent_id',
                'user_id',
                'created_at',
                'updated_at'
            ]
        ];
    }

    /**
     * Test structure of json response and code when success.
     *
     * @return void
     */
    public function testEditCommentSuccess(){
        $user = $this->makeData(5);
        $this->be($user);
        // $this->withoutMiddleware();

        $response = $this->put('/api/comments/1', ['comment' => 'Comment example'], ['access-token' => '1']);
        $response->assertJsonStructure($this->jsonStructureEditComment())
                 ->assertStatus(Response::HTTP_OK);
    }

    /**
    * Make data for test.
    *
    * @return void
    */
    public function makeData($row)
    {
        $faker = Faker::create();

        $user = factory(User::class)->create([
            'access_token' => '1'
        ]);

        $categories = factory(Category::class)->create();

        $language = factory(Language::class)->create([
            'language' =>  $faker->randomElement(Language::LANGUAGES),
        ]);

        $books = factory(Book::class)->create([
            'category_id' => $categories->id,
            'language_id' => $language->id,
            'from_person' => $user->employ_code,
        ]);

        factory(Comment::class, $row)->create([
            'commentable_id' => $books->id,
            'commentable_type' => Comment::BOOK_TYPE,
            'user_id' => $user->id
        ]);

        return $user;
    }
}
