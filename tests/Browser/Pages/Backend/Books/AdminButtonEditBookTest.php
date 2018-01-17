<?php

namespace Tests\Browser\Pages\Backend\Books;

use App\Model\Book;
use App\Model\User;
use App\Model\Category;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;

class AdminButtonEditBookTest extends DuskTestCase
{
    use DatabaseMigrations;
    
    /**
     * Override function setUp() for make user login
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->makeUserLogin();
    }

    /**
     * Test admin click button edit book in list books
     *
     * @return void
     */
    public function testClickButtonEditBook()
    {
        $this->makeData(1);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books')
                    ->assertSee('List Books');
            $elements = $browser->elements('#list-books tbody tr');
            $this->assertCount(1, $elements);
            $browser->click('td a.fa-pencil')
                    ->assertSee('Edit Book')
                    ->assertPathIs('/admin/books/1/edit');
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
            'employ_code' => 'ATI0297',
            'name' => 'Minh Dao T.',
            'email' => 'minh.dao@asiantech.vn',
            'team' => 'SA',
            'is_admin' => '1',
        ]);
    }

    /**
     * Make data for test.
     *
     * @return void
     */
    public function makeData($row)
    {   
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
    }
}
