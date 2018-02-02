<?php

namespace Tests\Browser\Pages\Backend\Books;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Model\Category;
use App\Model\Book;
use Illuminate\Http\UploadedFile;
use Faker\Factory as Faker;
use Facebook\WebDriver\WebDriverBy;

class AdminEditBooksTest extends DuskTestCase
{

    use DatabaseMigrations;

    const NUMBER_RECORD_CREATE = 2;

    /**
     * Override function setUp()
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->makeData(self::NUMBER_RECORD_CREATE);
    }

    /**
     * Test Url Admin Edit Books.
     *
     * @return void
     */
    public function testUrlEditBooks()
    {

        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/books')
                    ->click('#list-books tbody tr:first-child td:nth-child(6) a')
                    ->assertSee('Edit Book')
                    ->assertPathIs('/admin/books/1/edit');
        });
    }

    /**
     * Test Edit Books Success.
     *
     * @return void
     */
    public function testEditBooksSuccess()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/books/1/edit')
                    ->resize(900,1000)
                    ->assertSee('Edit Book')
                    ->type('title','Zoey Toy Sr.')
                    ->press('Update')
                    ->assertSee('Edit book success!')
                    ->assertPathIs('/admin/books');                                                   
        });
        $this->assertDatabaseHas('books', [
                        'title' => 'Zoey Toy Sr.']);
    }

    /**
     * Test Buton Back in page Edit Books.
     *
     * @return void
     */
    public function testBtnCancer()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/books')
                    ->click('#list-books tbody tr:first-child td:nth-child(6) a')
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
        $categoryIds = factory(Category::class)->create()->pluck('id')->toArray();
        $faker = Faker::create();
        factory(Book::class, 1)->create([
            'category_id' => $faker->randomElement($categoryIds),
            'from_person' => "ATI0297",
        ]);
    }
}
