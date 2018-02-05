<?php

namespace Tests\Browser\Pages\Backend\Posts;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Model\User;
use Faker\Factory as Faker;
use App\Model\Post;
use App\Model\Category;
use App\Model\Borrow;
use App\Model\Book;
use DB;
class AdminListPosts extends DuskTestCase
{
    use DatabaseMigrations;

    const NUMBER_RECORD_CREATE = 18;

    /**
     * Override function setUp()
     *
     * @return void
     */
    public function setUp(){
        parent::setUp();
    }

    /**
     * A Dusk test show view list posts.
     *
     * @return void
     */
    public function testListPosts()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin')
                ->clickLink('Posts')
                ->assertPathIs('/admin/posts')
                ->assertSee('List Posts');
        });
    }

    /**
     * A Dusk test see link content.
     *
     * @return void
     */
    public function testSeeLinkContent()
    {
        $this->makeData(self::NUMBER_RECORD_CREATE);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin')
                ->clickLink('Posts')
                ->assertPathIs('/admin/posts')
                ->assertSee('List Posts')
                ->visit($browser->attribute('#list-posts tbody td:nth-child(2) a ', 'href'))
                ->assertSee('Detail post');
        });
    }

    /**
     * A Dusk test list posts if empty data posts
     *
     * @return void
     */
    public function testListPostsEmpty()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/posts')
                ->resize(1200,1600)
                ->assertSee('List Posts');
            $elements = $browser->elements('#list-posts tbody tr');
            $this->assertCount(0, $elements);
            $this->assertNull($browser->element('.paginate'));
        });
    }

    /**
    * A Dusk test show record with table posts has data.
    *
    * @return void
    */
    public function testShowRecord()
    {
        $this->makeData(4);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->resize(1200,1600)
                ->visit('/admin/posts');
            $elements = $browser->elements('#list-posts tbody tr');
            $this->assertCount(4, $elements);
        });
    }

    /**
     * A Dusk test view Admin List posts with pagination
     *
     * @return void
     */
    public function testListPostsPagination()
    {
        $this->makeData(self::NUMBER_RECORD_CREATE);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->resize(1200,1600)
                ->visit('/admin/posts');
            $elements = $browser->elements('#list-posts tbody tr');
            $this->assertCount(config('define.posts.limit_rows'), $elements);
            $this->assertNotNull($browser->element('.pagination'));
            $paginate_element = $browser->elements('.pagination li');
            $number_page = count($paginate_element) - 2;
            $this->assertTrue($number_page == ceil((self::NUMBER_RECORD_CREATE + 1) / (config('define.posts.limit_rows'))));
        });
    }

    /**
     * A Dusk test view Admin List posts with lastest pagination
     *
     * @return void
     */
    public function testPathPagination()
    {
        $this->makeData(self::NUMBER_RECORD_CREATE);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->resize(1200,1600)
                ->visit('/admin/posts?page='.ceil((self::NUMBER_RECORD_CREATE + 1) / (config('define.posts.limit_rows'))));
            $elements = $browser->elements('#list-posts tbody tr');
            $browser->assertPathIs('/admin/posts')
                ->assertQueryStringHas('page', ceil((self::NUMBER_RECORD_CREATE + 1) / (config('define.posts.limit_rows'))));
        });
    }

     /**
     * A Data test for users and posts
     *
     * @return void
     */
    public function makeData($row)
    {
        $faker = Faker::create();
        $users = factory(User::class, 4)->create();
        $userId = $users->pluck('id')->toArray();
        $employeeCode = $users->pluck('employ_code')->toArray();
        $categoryId = factory(Category::class, 2)->create()->pluck('id')->toArray();
        for ($i = 0; $i < $row; $i++) {
            $books[] = factory(Book::class)->create([
                'from_person' => $faker->randomElement($employeeCode),
                'category_id' => $faker->randomElement($categoryId),
            ]);
        }
        $userId = DB::table('users')->pluck('id')->toArray();
        for ($i = 0; $i < $row; $i++) {
            factory(Post::class)->create([
                'user_id' => $faker->randomElement($userId)
            ]);
        }
    }
}
