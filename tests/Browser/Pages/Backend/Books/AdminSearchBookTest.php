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

    /**
     * Override function setUp()
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * A Dusk test SearchNotInputValue SlectAll.
     *
     * @return void
     */
    public function testSearchBookNotInputValueSelectAll()
    {
        $this->makeData(6);
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
                    ->assertQueryStringHas('filter', 'all')->screenshot(1);
            $elements = $browser->elements('#list-books tbody tr');
            $this->assertCount(7, $elements);
        });
    }

    /**
     * A Dusk test SearchNotInputValue SelectTitle.
     *
     * @return void
     */
    public function testSearchBookNotInputValueSelectTitle()
    {
        $this->makeData(6);
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
                    ->assertQueryStringHas('filter', 'title')->screenshot(2);
            $elements = $browser->elements('#list-books tbody tr');
            $this->assertCount(7, $elements);
        });
    }

    /**
     * A Dusk test SearchNotInputValue SelectAuthor.
     *
     * @return void
     */
    public function testSearchBookNotInputValueSelectAuthor()
    {
        $this->makeData(6);
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
                    ->assertQueryStringHas('filter', 'author')->screenshot(3);
            $elements = $browser->elements('#list-books tbody tr');
            $this->assertCount(7, $elements);
        });
    }

    /**
     *Test search if has input value with filter is all and has record.
     *
     * @return void
     */
    public function testSearchBookHasInputValueSelectAll()
    {
        $this->makeData(6);
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
                    ->assertQueryStringHas('filter', 'all')->screenshot(4);
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
        $this->makeData(6);
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
                    ->assertQueryStringHas('filter', 'title')->screenshot(5);
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
        $this->makeData(6);
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
                    ->assertQueryStringHas('filter', 'author')->screenshot(6);
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
        $this->makeData(6);
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
                    ->assertQueryStringHas('filter', 'all')->screenshot(7);
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
        $this->makeData(6);
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
                    ->assertQueryStringHas('filter', 'title')->screenshot(8);
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
        $this->makeData(6);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/books')
                    ->resize(1200,1600)
                    ->assertSee('List Books')
                    ->type('search', 'Hello')
                    ->select('filter', 'author')
                    ->click('#btn-search')
                    ->visit('/admin/books?search=Hello&filter=author')
                    ->assertQueryStringHas('search', 'Hello')
                    ->assertQueryStringHas('filter', 'author')->screenshot(9);
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
        factory(Category::class, 2)->create();
        factory(User::class, 2)->create();
        $categoryId = DB::table('categories')->pluck('id')->toArray();
        $userId = DB::table('users')->pluck('employ_code')->toArray();
        $faker = Faker::create();
        for ($i = 0; $i < $row; $i++) {
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
