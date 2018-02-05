<?php

namespace Tests\Browser\Pages\Backend\Books;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Model\Book;
use App\Model\Borrow;
use App\Model\User;
use App\Model\Category;
use DB;
use Faker\Factory as Faker;

class AdminSearchBookTest extends DuskTestCase
{
    use DatabaseMigrations;
    const NUMBER_BOOKS = 6;

    /**
     * Override function setUp()
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->makeData(self::NUMBER_BOOKS);
    }

    /**
     * A Dusk test SearchNotInputValue SlectAll.
     *
     * @return void
     */
    public function testSearchBookNotInputValueSelectAll()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/books')
                ->resize(1200,1600)
                ->assertSee('List Books')
                ->assertInputValue('search', '')
                ->select('filter', 'all')
                ->click('#btn-search')
                ->visit('/admin/books?search=&filter=all')
                ->assertQueryStringHas('search', '')
                ->assertQueryStringHas('filter', 'all');
            $elements = $browser->elements('#list-books tbody tr');
            $this->assertCount(self::NUMBER_BOOKS, $elements);
        });
    }

    /**
     * A Dusk test SearchNotInputValue SelectTitle.
     *
     * @return void
     */
    public function testSearchBookNotInputValueSelectTitle()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/books')
                ->resize(1200,1600)
                ->assertSee('List Books')
                ->assertInputValue('search', '')
                ->select('filter', 'title')
                ->click('#btn-search')
                ->visit('/admin/books?search=&filter=title')
                ->assertQueryStringHas('search', '')
                ->assertQueryStringHas('filter', 'title');
            $elements = $browser->elements('#list-books tbody tr');
            $this->assertCount(self::NUMBER_BOOKS, $elements);
        });
    }

    /**
     * A Dusk test SearchNotInputValue SelectAuthor.
     *
     * @return void
     */
    public function testSearchBookNotInputValueSelectAuthor()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/books')
                ->resize(1200,1600)
                ->assertSee('List Books')
                ->assertInputValue('search', '')
                ->select('filter', 'author')
                ->click('#btn-search')
                ->visit('/admin/books?search=&filter=author')
                ->assertQueryStringHas('search', '')
                ->assertQueryStringHas('filter', 'author');
            $elements = $browser->elements('#list-books tbody tr');
            $this->assertCount(self::NUMBER_BOOKS, $elements);
        });
    }

    /**
     *Test search if has input value with filter is all and has record.
     *
     * @return void
     */
    public function testSearchBookHasInputValueSelectAll()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/books')
                ->resize(1200,1600)
                ->assertSee('List Books')
                ->type('search', 'Java')
                ->select('filter', 'all')
                ->click('#btn-search')
                ->visit('/admin/books?search=Java&filter=all')
                ->assertQueryStringHas('search', 'Java')
                ->assertQueryStringHas('filter', 'all');
            $elements = $browser->elements('#list-books tbody tr');
            $this->assertCount(1, $elements);
        });
    }

    /**
     *Test search if has input value with filter is title and has record.
     *
     * @return void
     */
    public function testSearchBookHasInputValueSelectTitle()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/books')
                ->resize(1200,1600)
                ->assertSee('List Books')
                ->type('search', 'Java')
                ->select('filter', 'title')
                ->click('#btn-search')
                ->visit('/admin/books?search=Java&filter=title')
                ->assertQueryStringHas('search', 'Java')
                ->assertQueryStringHas('filter', 'title');
            $elements = $browser->elements('#list-books tbody tr');
            $this->assertCount(1, $elements);
        });
    }

    /**
     *Test search if has input value with filter is author and has record.
     *
     * @return void
     */
    public function testSearchBookHasInputValueSelectAuthor()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/books')
                ->resize(1200,1600)
                ->assertSee('List Books')
                ->type('search', 'Pytago')
                ->select('filter', 'author')
                ->click('#btn-search')
                ->visit('/admin/books?search=Pytago&filter=author')
                ->assertQueryStringHas('search', 'Pytago')
                ->assertQueryStringHas('filter', 'author');
            $elements = $browser->elements('#list-books tbody tr');
            $this->assertCount(1, $elements);
        });
    }

    /**
     *Test search if has input value with filter is all and not has record.
     *
     * @return void
     */
    public function testSearchBookHasInputValueSelectAllNotResult()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/books')
                ->resize(1200,1600)
                ->assertSee('List Books')
                ->type('search', 'Hello')
                ->select('filter', 'all')
                ->click('#btn-search')
                ->visit('/admin/books?search=Hello&filter=all')
                ->assertQueryStringHas('search', 'Hello')
                ->assertQueryStringHas('filter', 'all');
            $elements = $browser->elements('#list-books tbody tr');
            $this->assertCount(0, $elements);
        });
    }

    /**
     *Test search if has input value with filter is title and not has record.
     *
     * @return void
     */
    public function testSearchBookHasInputValueSelectTitleNotResult()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/books')
                ->resize(1200,1600)
                ->assertSee('List Books')
                ->type('search', 'Hello')
                ->select('filter', 'title')
                ->click('#btn-search')
                ->visit('/admin/books?search=Hello&filter=title')
                ->assertQueryStringHas('search', 'Hello')
                ->assertQueryStringHas('filter', 'title');
            $elements = $browser->elements('#list-books tbody tr');
            $this->assertCount(0, $elements);
        });
    }

    /**
     *Test search if has input value with filter is author and not has record.
     *
     * @return void
     */
    public function testSearchBookHasInputValueSelectAuthorNotResult()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/books')
                ->resize(1200,1600)
                ->assertSee('List Books')
                ->type('search', '123456789')
                ->select('filter', 'author')
                ->click('#btn-search')
                ->visit('/admin/books?search=123456789&filter=author')
                ->assertQueryStringHas('search', '123456789')
                ->assertQueryStringHas('filter', 'author');
            $elements = $browser->elements('#list-books tbody tr');
            $this->assertCount(0, $elements);
        });
    }

    /**
     * Make data for test.
     *
     * @return void
     */
    public function makeData($row){
        $faker = Faker::create();
        $userId = factory(User::class, 2)->create()->pluck('employ_code')->toArray();
        $categoryId = factory(Category::class, 2)->create()->pluck('id')->toArray();
        for ($i = 0; $i < $row - 1; $i++) {
            factory(Book::class, 1)->create([
                'category_id' => $faker->randomElement($categoryId),
                'from_person' => $faker->randomElement($userId)
            ]);
        }
        factory(Book::class, 1)->create([
            'title' => 'Java',
            'author' => 'Pytago',
            'category_id' => $faker->randomElement($categoryId),
            'from_person' => $faker->randomElement($userId)
        ]);
    }
}
