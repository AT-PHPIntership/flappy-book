<?php
namespace Tests\Browser;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Model\Book;
use App\Model\User;
use App\Model\Borrow;
use App\Model\Category;
use Faker\Factory as Faker;
use Facebook\WebDriver\WebDriverBy;
use DB;

class AdminCreateBooksTest extends DuskTestCase
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
        $this->createUserForLogin();
    }

    /**
     * Test url create book
     *
     * @return void
     */
    public function testCreateBooksUrl()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/books')
                    ->press('Add Book')
                    ->assertPathIs('/admin/books/create')
                    ->assertSee('Create Book');
        });
    }

    /**
     * List case for Test validate for input Create Book
     *
     */
    public function listCaseTestValidateForInput()
    {
        return [
            ['title', '', 'The title field is required.'],
            ['price', '', 'The price field is required.'],
            ['author', '', 'The author field is required.'],
            ['year', '', 'The year field is required.'],
            ['from_person','', 'The from person field is required.'],
            ['title', 'Title', 'The title must be at least 6 characters.'],
            ['price', 'abcde', 'The price must be a number.'],
            ['from_person','AT0002', 'The selected from person is invalid.'],
            ['year','12345','The year does not match the format Y.'],
        ];
    }

    /**
     * Dusk test validate for input
     *
     * @dataProvider listCaseTestValidateForInput
     *
     * @return void
     */
    public function testValidateForInput($name, $content, $message)
    {
        $this->browse(function (Browser $browser) use ($name, $content, $message)
        {
            $browser->loginAs(User::find(1))
                    ->visit('admin/books/create')
                    ->resize(900,1000)
                    ->type('title', 'Title for book')
                    ->type('price', '1000')
                    ->type('author', 'Cao Nguyen V.')
                    ->type('year', '1995')
                    ->type('from_person', 'AT0001')
                    ->type($name, $content);

            $this->typeInCKEditor('.wysihtml5-sandbox', $browser, 'Description for book');

            $browser->press('Create')
                    ->assertSee($message)
                    ->assertPathIs('/admin/books/create');
        });
    }

    /**
     * Dusk test validate for textarea
     *
     * @return void
     */
    public function testValidateForTextarea()
    {
        $this->browse(function (Browser $browser)
        {
            $browser->loginAs(User::find(1))
                    ->visit('admin/books/create')
                    ->resize(900,1000)
                    ->type('title', 'Title for book')
                    ->type('price', '1000')
                    ->type('author', 'Cao Nguyen V.')
                    ->type('year', '1995')
                    ->type('from_person', 'AT0001');

            $this->typeInCKEditor('.wysihtml5-sandbox', $browser, '');

            $browser->press('Create')
                    ->assertSee('The description field is required.')
                    ->assertPathIs('/admin/books/create');
        });
    }

    /**
     * Dusk test button back
     *
     * @return void
     */
    public function testBackButton()
    {
        $this->browse(function (Browser $browser)
        {
            $browser->loginAs(User::find(1))
                ->visit('admin/books')
                ->resize(900,1000)
                ->press('Add Book')
                ->press('Back')
                ->assertPathIs('/admin/books');
        });
    }

    /**
     * Dusk test create book success.
     *
     * @return void
     */
    public function testCreatesBookSuccess()
    {
        $this->makeData(5);
        $this->browse(function (Browser $browser)
        {
            $browser->loginAs(User::find(1))
                    ->visit('admin/books/create')
                    ->resize(900,1000)
                    ->type('title', 'Title for book')
                    ->type('price', '1000')
                    ->type('author', 'Cao Nguyen V.')
                    ->type('year', '1995')
                    ->type('from_person', 'AT0001');

            $this->typeInCKEditor('.wysihtml5-sandbox', $browser, 'Description for book');

            $browser->press('Create')
                    ->assertPathIs('/admin/books')
                    ->assertSee('Create Success');
        });
    }

    /**
     * Input value for description
     * @param  string               $selector selector
     * @param  Laravel\Dusk\Browser $browser  browser
     * @param  string               $content  description of books
     * @return void
     */
    public function typeInCKEditor ($selector, $browser, $content)
    {
       $ckIframe = $browser->elements($selector)[0];
       $browser->driver->switchTo()->frame($ckIframe);
       $body = $browser->driver->findElement(WebDriverBy::xpath('//body'));
       $body->sendKeys($content);
       $browser->driver->switchTo()->defaultContent();
    }

    /**
     * Create admin for login
     *
     * @return void
     */
    public function createUserForLogin()
    {
        factory(User::class, 1)->create([
            'is_admin' => 1,
            'employ_code' => 'AT0001'
        ]);
    }

    /**
     * Make data  in database for test.
     *
     * @return void
     */
    public function makeData($row)
    {
        factory(Category::class, $row)->create();
    }
}
