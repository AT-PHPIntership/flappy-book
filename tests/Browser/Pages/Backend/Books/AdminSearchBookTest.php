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
     * A Dusk test example.
     *
     * @return void
     */
    public function testSearchNotInputValue()
    {
        $this->makeUserLogin();
        $this->makeData(16);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
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
     *Test search if has input value and has one record.
     *
     * @return void
     */
    public function testSearchHasInputValue()
    {
        $this->makeUserLogin();
        $this->makeData(16);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
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
     *Test search has input value but not found.
     *
     * @return void
     */
    public function testSearchNotResult()
    {
        $this->makeUserLogin();
        $this->makeData(16);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books')
                    ->resize(1000,1200)
                    ->type('search', 'Hello')
                    ->select('filter','Title')->screenshot(1)
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
     *Test search has input value and has many record.
     *
     * @return void
     */
    public function testHasManyRecord()
    {
        $this->makeUserLogin();
        $this->makeData(16);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
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
     * Make user belong team SA and is admin
     *
     * @return void
     */
    public function makeUserLogin()
    {
        factory(User::class, 1)->create([
            'employ_code' => 'ATI0290',
            'name' => 'Hieu Le T.',
            'email' => 'hieu.le@asiantech.vn',
            'team' => 'SA',
            'is_admin' => '1',
        ]);
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
            factory(Book::class, 1)->create([
              'title' => 'Jac-'.$i,
              'category_id' => $faker->randomElement($categoryId),
              'from_person' => $faker->randomElement($userId)
            ]);
        }
    }
}
