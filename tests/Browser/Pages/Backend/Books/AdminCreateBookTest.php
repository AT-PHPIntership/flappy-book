<?php
namespace Tests\Browser;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Model\User;
use App\Model\Category;
use App\Model\Language;
use Faker\Factory as Faker;
use Facebook\WebDriver\WebDriverBy;
use DB;

class AdminCreateBookTest extends DuskTestCase
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
    }

    /**
     * Test url create book
     *
     * @return void
     */
    public function testCreateBooksUrl()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/books')
                ->press('Add Book')
                ->assertPathIs('/admin/books/create')
                ->assertSee('Create Book');
        });
    }

    /**
     * List case for Test validate for input Create Book
     *
     * @return array
     */
    public function listCaseTestValidateForInput()
    {
        return [
            ['title', '', 'The title field is required.'],
            ['price', '', 'The price field is required.'],
            ['author', '', 'The author field is required.'],
            ['year', '', 'The year field is required.'],
            ['from_person','', 'The from person field is required.'],
            ['price', 'abcde', 'The price must be a number.'],
            ['from_person', 'AT0002', 'The selected from person is invalid.'],
            ['year', '12345', 'The year does not match the format Y.'],
            ['page_number', 'abcde', 'The page number must be a number.'],
        ];
    }

    /**
     * Dusk test validate for input
     *
     * @param string $name    name of field
     * @param string $content content
     * @param string $message message show when validate
     *
     * @dataProvider listCaseTestValidateForInput
     *
     * @return void
     */
    public function testValidateForInput($name, $content, $message)
    {
        $employ_code = $this->makeData()->employ_code;

        $this->browse(function (Browser $browser) use ($name, $content, $message, $employ_code) {
            $browser->loginAs($this->user)
                ->visit('admin/books/create')
                ->resize(900, 1000)
                ->type('title', 'Title for book')
                ->type('price', '1000')
                ->type('author', 'Cao Nguyen V.')
                ->type('year', '1995')
                ->type('from_person', $employ_code)
                ->type('page_number', '200')
                ->type($name, $content);

            $this->fillTextArea('.wysihtml5-sandbox', $browser, 'Description for book');

            $browser->press('Create')
                ->assertSee($message);
        });
    }

    /**
     * Dusk test validate for textarea
     *
     * @return void
     */
    public function testValidateForTextarea()
    {
        $employ_code = $this->makeData()->employ_code;

        $this->browse(function (Browser $browser) use ($employ_code) {
            $browser->loginAs($this->user)
                ->visit('admin/books/create')
                ->resize(900, 1000)
                ->type('title', 'Title for book')
                ->type('price', '1000')
                ->type('author', 'Cao Nguyen V.')
                ->type('year', '1995')
                ->type('from_person', $employ_code)
                ->type('page_number', '200');
                

            $this->fillTextArea('.wysihtml5-sandbox', $browser, '');

            $browser->press('Create')
                ->assertSee('The description field is required.');
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
            $browser->loginAs($this->user)
                ->visit('admin/books')
                ->resize(900,1000)
                ->press('Add Book')
                ->press('Back')
                ->assertSee('List Books');
        });
    }

    /**
     * Dusk test create book success.
     *
     * @return void
     */
    public function testCreatesBookSuccess()
    {
        $employ_code = $this->makeData()->employ_code;

        $this->browse(function (Browser $browser) use ($employ_code)
        {
            $browser->loginAs($this->user)
                ->visit('admin/books/create')
                ->resize(900,1000)
                ->type('title', 'Title for book')
                ->type('price', '1000')
                ->type('author', 'Cao Nguyen V.')
                ->type('year', '1995')
                ->type('from_person', $employ_code)
                ->type('page_number', '200');

            $this->fillTextArea('.wysihtml5-sandbox', $browser, 'Description for book');

            $browser->press('Create')
                ->pause(1000)
                ->assertSee('Create Success');
        });
    }

    /**
     * Input value for description
     *
     * @param string               $selector selector
     * @param Laravel\Dusk\Browser $browser  browser
     * @param string               $content  description of books
     *
     * @return void
     */
    public function fillTextArea($selector, $browser, $content)
    {
        $frame = $browser->elements($selector)[0];
        $browser->driver->switchTo()->frame($frame);
        $body = $browser->driver->findElement(WebDriverBy::xpath('//body'));
        $body->sendKeys($content);
        $browser->driver->switchTo()->defaultContent();
    }

    /**
     * Make data  in database for test.
     *
     * @return App\Model\User
     */
    public function makeData()
    {
        $faker = Faker::create();
        factory(Category::class, 2)->create();
        factory(Language::class)->create([
            'language' => $faker->randomElement(Language::LANGUAGES),
        ]);
        return factory(User::class)->create();
    }
}
