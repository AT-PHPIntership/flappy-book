<?php

namespace Tests\Browser\Pages\Backend\Cattegories;

use App\Model\User;
use App\Model\Category;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;
use DB;

class AdminEditCategoryTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * user for login
     * @var App\Model\User
     */
    protected $user;

    /**
     * Override function setUp()
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->user = $this->createAdminUser();
    }

    /**
     * Test view Admin Edit button
     *
     * @return void
     */
    public function testButtonEditCategory()
    {
        makeData(5);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/categories')
                    ->assertSee('List Categories');
            $elements = $browser->elements('.btn-edit-category');
            $this->assertCount(5, $elements);
        });
    }

   /**
     * Test click Edit button
     *
     * @return void
     */
    public function testClickButtonEditCategory()
    {
        $this->makeData(1);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/categories')
                    ->assertSee('List Categories');
            $element = $browser->element('.category-title-field p');
            $browser->press('.btn-edit-category')
                    ->assertInputValue('.category-title-field input', $element->getText());
        });
    }

    /**
     * Test show popup confirm edit
     *
     * @return void
     */
    public function testShowConfirmEditCategory()
    {
        $this->makeData(1);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/categories')
                    ->press('.btn-edit-category')
                    ->keys('.category-title-field input', '{enter}', 'otwell')
                    ->assertSee('Confirm edit!')
                    ->assertSee('Do you want edit');
        });
    }

    /**
     * Test button cancel button in popup confirm edit
     *
     * @return void
     */
    public function testCancelButtonConfirm()
    {
        $this->makeData(1);
        $this->browse(function (Browser $browser) {
            $input = '.category-title-field input';
            $text = '.category-title-field p';
            $browser->loginAs(User::find(1))
                    ->visit('/admin/categories')
                    ->press('.btn-edit-category')
                    ->keys($input, '{enter}', 'otwell');
            $value = $browser->value($input);
            $browser->press('Cancel')
                    ->assertInputValue($input, $value);
            $this->assertTrue($browser->attribute($input, 'hidden') == 'false');
            $this->assertTrue($browser->attribute($text, 'hidden') == 'true');
        });
    }

    /**
     * List case for Test validate for input edit category
     *
     */
    public function listCaseTestValidateForInput()
    {
        return [
            ['', 'The title field is required.'],
            ['title test', 'The title has already been taken.'],
        ];
    }

    /**
     * Test button reset button in popup confirm edit
     *
     * @return void
     */
    public function testResetButtonConfirm()
    {
        $this->makeData(1);
        $this->browse(function (Browser $browser) {
            $input = '.category-title-field input';
            $text = '.category-title-field p';
            $browser->loginAs(User::find(1))
                    ->visit('/admin/categories')
                    ->press('.btn-edit-category')
                    ->keys($input, '{enter}', 'otwell');
            $value = $browser->value($text);
            $browser->press('Reset')
                    ->assertInputValue($input, $value);
            $this->assertTrue($browser->attribute($input, 'hidden') == 'true');
            $this->assertTrue($browser->attribute($text, 'hidden') == 'false');
        });
    }

    /**
     * Test validate for title
     *
     * @dataProvider listCaseTestValidateForInput
     *
     * @return void
     */
    public function testValidateEditCategory($content, $message)
    {
        factory()->create([
            'title' => 'title test',
        ]);
        $this->makeData(1);
        $this->browse(function (Browser $browser) use ($content, $message) {
            $input = '.category-title-field input';
            $text = '.category-title-field p';
            $browser->loginAs(User::find(1))
                    ->visit('/admin/categories')
                    ->press('.btn-edit-category')
                    ->type('title', $content)
                    ->keys($input, '{enter}', 'otwell');
            $browser->press('Edit')
                    ->assertSee($message);
            $this->assertTrue($browser->attribute($input, 'hidden') == 'false');
            $this->assertTrue($browser->attribute($text, 'hidden') == 'true');
        });
    }

    /**
     * Make data for test.
     *
     * @return void
     */
    public function makeData($row)
    {
        factory(Category::class, $row)->create();
    }
}
