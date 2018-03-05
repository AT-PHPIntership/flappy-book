<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use App\Model\Book;
use App\Model\User;
use App\Model\Category;
use App\Model\Post;
use App\Model\Rating;
use Faker\Factory as Faker;

class PostsOfUserApiTest extends TestCase
{
    use DatabaseMigrations;

    const NUMBER_RECORD_CREATE = 25;
    protected $user;

    /**
     * Override function setUp() for make user login
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->withoutMiddleWare();
        $this->makeData(self::NUMBER_RECORD_CREATE);
        $this->user = User::first();
        $this->be($this->user);
    }

    /**
     * Test status response
     *
     * @return void
     */
    public function testStatusCode()
    {
        $response = $this->json('GET', 'api/users/' . $this->user->id . '/posts');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test struct json.
     *
     * @return void
     */
    public function testStructJson()
    {
        $response = $this->json('GET', 'api/users/' . $this->user->id . '/posts');
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
                    'name',
                    'team',
                    'avatar_url',
                    'is_admin',
                    'picture',
                    'title',
                    'book_id',
                    'rating',
                    'likes',
                    'created_at',
                    'updated_at',
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
        $response = $this->json('GET', 'api/users/' . $this->user->id . '/posts');
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
        $response = $this->json('GET', 'api/users/' . $this->user->id . '/posts?page=2');
        $response->assertJson([
            'pagination' => [
                'total' => self::NUMBER_RECORD_CREATE,
                'per_page' => config('define.posts.limit_rows_posts_of_user'),
                'current_page' => 2,
                'total_pages' => 2,
            ]
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test result pagination.
     *
     * @return void
     */
    public function testPaginationResultHasFilter()
    {
        $data = [
            'status' => Post::TYPE_REVIEW_BOOK,
            'page' => 2
        ];
        $response = $this->json('GET', 'api/users/' . $this->user->id . '/posts', $data);
        $response->assertJson([
            'pagination' => [
                'total' => self::NUMBER_RECORD_CREATE,
                'per_page' => config('define.posts.limit_rows_posts_of_user'),
                'current_page' => 2,
                'total_pages' => 2,
            ]
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Make data for test.
     *
     * @param int $row number record create
     *
     * @return void
     */
    public function makeData($row)
    {
        $users = factory(User::class)->create();

        $categories = factory(Category::class)->create();

        $books = factory(Book::class)->create([
            'category_id' => $categories->id,
            'from_person' => $users->employ_code,
        ]);

        $posts = factory(Post::class, $row)->create([
            'user_id' => $users->id,
            'status' => Post::TYPE_REVIEW_BOOK,
        ]);

        $faker = Faker::create();
        $postsId = $posts->pluck('id')->toArray();
        $booksId = $books->pluck('id')->toArray();
        factory(Rating::class)->create([
            'post_id' => $faker->randomElement($postsId),
            'book_id' => $faker->randomElement($booksId),
        ]);
    }
}
