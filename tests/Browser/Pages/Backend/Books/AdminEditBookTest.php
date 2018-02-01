<?php

namespace Tests\Browser\Pages\Backend\Books;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Model\Category;
use App\Model\User;
use App\Model\Book;
use Illuminate\Http\UploadedFile;
use Faker\Factory as Faker;
use DB;
use Carbon\Carbon;
use Facebook\WebDriver\WebDriverBy;

class AdminEditBooksTest extends DuskTestCase
{

    use DatabaseMigrations;

    /**
     * Test Url Admin Edit Books.
     *
     * @return void
     */
    public function testUrlEditBooks()
    {
        $this->makeData(10);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/books')
                    ->click('#list-books tbody tr:nth-child(1) td:nth-child(6) a')
                    ->assertSee('Edit Book')
                    ->assertPathIs('/admin/books/10/edit');
        });
    }


    /**
     * Test Edit Books Success.
     *
     * @return void
     */
    public function testEditBooksSuccess()
    {
        $this->makeData(10);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/books/1/edit')
                    ->resize(900,1000)
                    ->assertSee('Edit Book')
                    ->type('title','Felicity Brekke')
                    ->press('Update')
                    ->assertSee('Edit book success!')
                    ->assertPathIs('/admin/books');
        });
        $this->assertDatabaseHas('books', [
                        'title' => 'Felicity Brekke']);
    }

    /**
     * Test Buton Back in page Edit Books.
     *
     * @return void
     */
    public function testBtnCancer()
    {
        $this->makeData(10);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/books')
                    ->click('#list-books tbody tr:nth-child(1) td:nth-child(6) a')
                    ->resize(900,1000)
                    ->assertSee('Edit Book')
                    ->press('Back')
                    ->assertSee('List Books')
                    ->assertPathIs('/admin/books');
        });
    }

    /**
     *List case for test validation Edit Books
     *
     *@return array
     */
    public function listCaseTestForEditBooks()
    {
        return [
            ['title', '','The title field is required.'],
            ['price', '', 'The price field is required.'],
            ['author', '', 'The author field is required.'],
            ['from_person','', 'The from person field is required.'],
            ['title', 'Title', 'The title must be at least 6 characters.'],
            ['price', 'abcde', 'The price must be a number.'],
            ['year','12345','The year does not match the format Y.'],
        ];
    }

    /**
     * @dataProvider listCaseTestForEditBooks
     *
     */
    public function testValidateEditBooks($title, $content, $msg)
    {
        $this->makeData(10);
        $this->browse(function (Browser $browser) use ($title, $content, $msg) {
            $browser->loginAs($this->user)
                ->visit('/admin/books/1/edit')
                ->resize(900,1000)
                ->type($title, $content)
                ->press('Update')
                ->assertSee($msg)
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
        factory(Category::class, 1)->create();
        $categoryIds = Category::all('id')->pluck('id')->toArray();
        $faker = Faker::create();
        for ($i = 0; $i < $row; $i++) {
            factory(Book::class, 1)->create([
                'category_id' => $faker->randomElement($categoryIds),
                'from_person' => "ATI0297",
            ]);
        }
    }

}
