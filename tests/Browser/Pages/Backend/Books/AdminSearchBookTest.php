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
        $this->createAdminUser();
        factory(Category::class, 2)->create();
        factory(User::class, 2)->create();
    }

    /**
     * A Dusk test SearchNotInputValue.
     *
     * @return void
     */
    public function testSearchNotInputValue()
    {
        $this->makeData(16);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                    ->visit('/admin/books')
                    ->assertSee('List Books')
                    ->press('#btn-search')
                    ->assertPathIs('/admin/books')
                    ->assertQueryStringMissing('Search');
                    $paginate_element = $browser->elements('.pagination li');
                    $number_page = count($paginate_element) - 2;
                    $this->assertTrue($number_page == 2);
        });
    }

    /**
     *Test search if has input value with filter is title and has one record.
     *
     * @return void
     */
    public function testSearchTitleHasInputValue()
    {
        $this->makeData(16);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                    ->visit('/admin/books')
                    ->resize(1000,1200)
                    ->type('search', 'Jac-16')
                    ->select('filter','Title')
                    ->click('#btn-search');
            $elements = $browser->elements('#list-books tbody tr');
            $numAccounts = count($elements);
            $this->assertTrue($numAccounts == 1);
            $browser->assertPathIs('/admin/books')
                    ->assertQueryStringHas('search', 'Jac-16')
                    ->assertMissing('.pagination');
        });
    }

    /**
     *Test search has input value with filter is title but not found.
     *
     * @return void
     */
    public function testSearchTitleNotResult()
    {
        $this->makeData(16);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                    ->visit('/admin/books')
                    ->resize(1000,1200)
                    ->type('search', 'Hello')
                    ->select('filter','Title')
                    ->click('#btn-search');
            $elements = $browser->elements('#list-books tbody tr');
            $numAccounts = count($elements);
            $this->assertTrue($numAccounts == 0);
            $browser->assertPathIs('/admin/books')
                    ->assertQueryStringHas('search', 'Hello')
                    ->assertMissing('.pagination');
        });
    }

    /**
     *Test search has input value with filter is title and has many record.
     *
     * @return void
     */
    public function testSearchTitleHasManyRecord()
    {
        $this->makeData(16);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                    ->visit('/admin/books')
                    ->resize(1000,1200)
                    ->type('search', 'Jac')
                    ->select('filter','Title')
                    ->press('#btn-search');
            $elements = $browser->elements('#list-books tbody tr');        
            $numAccounts = count($elements);
            $this->assertTrue($numAccounts == 10);
            $browser->assertPathIs('/admin/books')
                    ->assertQueryStringHas('search', 'Jac');
            $paginate_element = $browser->elements('.pagination li');
            $number_page = count($paginate_element) -2;
            $this->assertTrue($number_page == 2);
        }); 
    }

    /**
     *Test search if has input value with filter is author and has one record.
     *
     * @return void
     */
    public function testSearchAuthorHasInputValue()
    {
        $this->makeData(16);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                    ->visit('/admin/books')
                    ->resize(1000,1200)
                    ->type('search', 'Jac-16')
                    ->select('filter','Author')
                    ->click('#btn-search');
            $elements = $browser->elements('#list-books tbody tr');
            $numAccounts = count($elements);
            $this->assertTrue($numAccounts == 1);
            $browser->assertPathIs('/admin/books')
                    ->assertQueryStringHas('search', 'Jac-16')
                    ->assertMissing('.pagination');
        });
    }

    /**
     *Test search has input value with filter is author but not found.
     *
     * @return void
     */
    public function testSearchAuthorNotResult()
    {
        $this->makeData(16);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                    ->visit('/admin/books')
                    ->resize(1000,1200)
                    ->type('search', 'Hello')
                    ->select('filter','Author')
                    ->click('#btn-search');
            $elements = $browser->elements('#list-books tbody tr');
            $numAccounts = count($elements);
            $this->assertTrue($numAccounts == 0);
            $browser->assertPathIs('/admin/books')
                    ->assertQueryStringHas('search', 'Hello')
                    ->assertMissing('.pagination');
        });
    }

    /**
     *Test search has input value with filter is author and has many record.
     *
     * @return void
     */
    public function testAuthorHasManyRecord()
    {
        $this->makeData(16);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                    ->visit('/admin/books')
                    ->resize(1000,1200)
                    ->type('search', 'Jac')
                    ->select('filter','Author')
                    ->press('#btn-search');
            $elements = $browser->elements('#list-books tbody tr');        
            $numAccounts = count($elements);
            $this->assertTrue($numAccounts == 10);
            $browser->assertPathIs('/admin/books')
                    ->assertQueryStringHas('search', 'Jac');
            $paginate_element = $browser->elements('.pagination li');
            $number_page = count($paginate_element) -2;
            $this->assertTrue($number_page == 2);
        }); 
    }

    /**
     *Test search if has input value with filter is all and has one record.
     *
     * @return void
     */
    public function testSearchAllHasInputValue()
    {
        $this->makeData(16);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                    ->visit('/admin/books')
                    ->resize(1000,1200)
                    ->type('search', 'Jac-16')
                    ->select('filter','Title or Author')
                    ->click('#btn-search');
            $elements = $browser->elements('#list-books tbody tr');
            $numAccounts = count($elements);
            $this->assertTrue($numAccounts == 1);
            $browser->assertPathIs('/admin/books')
                    ->assertQueryStringHas('search', 'Jac-16')
                    ->assertMissing('.pagination');
        });
    }

    /**
     *Test search has input value with filter is all but not found.
     *
     * @return void
     */
    public function testSearchAllNotResult()
    {
        $this->makeData(16);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                    ->visit('/admin/books')
                    ->resize(1000,1200)
                    ->type('search', 'Hello')
                    ->select('filter','Title or Author')
                    ->click('#btn-search');
            $elements = $browser->elements('#list-books tbody tr');
            $numAccounts = count($elements);
            $this->assertTrue($numAccounts == 0);
            $browser->assertPathIs('/admin/books')
                    ->assertQueryStringHas('search', 'Hello')
                    ->assertMissing('.pagination');
        });
    }

    /**
     *Test search has input value with filter is all and has many record.
     *
     * @return void
     */
    public function testAllHasManyRecord()
    {
        $this->makeData(16);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                    ->visit('/admin/books')
                    ->resize(1000,1200)
                    ->type('search', 'Jac')
                    ->select('filter','Title or Author')
                    ->press('#btn-search');
            $elements = $browser->elements('#list-books tbody tr');        
            $numAccounts = count($elements);
            $this->assertTrue($numAccounts == 10);
            $browser->assertPathIs('/admin/books')
                    ->assertQueryStringHas('search', 'Jac');
            $paginate_element = $browser->elements('.pagination li');
            $number_page = count($paginate_element) -2;
            $this->assertTrue($number_page == 2);
        }); 
    }

    /**
     * Make data for test.
     *
     * @return void
     */
    public function makeData(){
        factory(Category::class, 2)->create();
        factory(User::class, 2)->create();
        $categoryId = DB::table('categories')->pluck('id')->toArray();
        $userId = DB::table('users')->pluck('employ_code')->toArray();
        $faker = Faker::create();
        for ($i = 1 ; $i <= 16; $i++) {
            factory(Book::class)->create([
              'title' => 'Jac-'.$i,
              'author'=> 'Jac-'.$i,
              'category_id' => $faker->randomElement($categoryId),
              'from_person' => $faker->randomElement($userId)
            ]);
        }
    }
}
