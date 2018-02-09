<?php

namespace Tests\Browser\Pages\Backend\Books;

use App\Model\Book;
use App\Model\User;
use App\Model\Category;
use App\Model\Qrcode;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;

class AdminListBooksTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Override function setUp()
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        factory(Category::class, 2)->create();
        factory(User::class, 2)->create();
    }

    /**
     * Test view Admin List Books if database has record or empty.
     *
     * @return void
     */
    public function testListBooks()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin')
                    ->clickLink('Books')
                    ->assertPathIs('/admin/books')
                    ->assertSee('List Books');
        });
    }

    /**
     * Test view Admin List Books if database empty
     *
     * @return void
     */
    public function testListBooksEmpty()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/books')
                    ->assertSee('List Books');
            $elements = $browser->elements('#list-books tbody tr');
            $this->assertCount(0, $elements);
            $this->assertNull($browser->element('.paginate'));
        });
    }
    
    /**
     * Test view Admin List Books if database has record
     *
     * @return void
     */
    public function testListBooksHasRecord()
    {
        $this->makeData(2);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/books')
                    ->assertSee('List Books');
            $elements = $browser->elements('#list-books tbody tr');
            $this->assertCount(2, $elements);
            $this->assertNull($browser->element('.pagination'));
        });
    }

    /**
     * Test view Admin List Books with pagination
     *
     * @return void
     */
    public function testListBooksPagination()
    {
        $this->makeData(12);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/books')
                    ->assertSee('List Books');
            // Count row number in one page
            $elements = $browser->elements('#list-books tbody tr');
            $this->assertCount(10, $elements);
            $this->assertNotNull($browser->element('.pagination'));
            //Count page number of pagination
            $paginate_element = $browser->elements('.pagination li');
            $number_page = count($paginate_element)- 2;
            $this->assertTrue($number_page == 2);
        });
    }

    /**
     * Test view Admin List Books with lastest pagination
     *
     * @return void
     */
    public function testPathPagination()
    {
        $this->makeData(12);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/books?page=2')
                    ->assertSee('List Books');
            $elements = $browser->elements('#list-books tbody tr');
            $this->assertCount(2, $elements);
            $browser->assertPathIs('/admin/books')
                    ->assertQueryStringHas('page', 2);
        });
    }

    /**
     * Make data for test.
     *
     * @return void
     */
    public function makeData($row)
    {   
        $categoryId = DB::table('categories')->pluck('id')->toArray();
        $userId = DB::table('users')->pluck('employ_code')->toArray();
        $faker = Faker::create();
        for ($i = 0; $i < $row; $i++) {
            factory(Book::class, 1)->create([
                'category_id' => $faker->randomElement($categoryId),
                'from_person' => $faker->randomElement($userId)
            ]);
        }
        $bookId = DB::table('books')->pluck('id')->toArray();
        for ($i = 0; $i < $row; $i++) {
            factory(Qrcode::class)->create([
                'book_id' => $faker->unique()->randomElement($bookId)
            ]);
        }
    }
}
