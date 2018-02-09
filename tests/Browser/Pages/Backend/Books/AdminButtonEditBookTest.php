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

class AdminButtonEditBookTest extends DuskTestCase
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
     * Test admin click button edit book in list books
     *
     * @return void
     */
    public function testClickButtonEditBook()
    {
        $this->makeData(1);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
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
