<?php

namespace Tests\Browser\Pages\Backend\Language;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Model\Language;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AddLanguageTest extends DuskTestCase
{
    use DatabaseMigrations;

    const LANGUAGE_CREATED = 'English';
    const LANGUAGE_NOT_EXIST = 'Vietnamese';

    /**
     * Override function setUp()
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->makeData();        
    }

    /**
     * Test Admin can see button Add Language
     *
     * @return void
     */
    public function testSeeAddButtonLanguage()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/languages')
                ->assertSee('Add Language');
        });
    }

    /**
     * Test Admin click button add on List Languages
     *
     * @return void
     */
    public function testClickButtonAdd()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/languages')
                ->press('#btn-add-language')
                ->assertSee('Language:');
        });
    }

    /**
     * Test Admin click button Add on Popup when no input data
     *
     * @return void
     */
    public function testClickAddOnPopUpNoInput() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/languages')
                ->press('#btn-add-language')
                ->assertSee('Language:')
                ->press('Add')
                ->pause(1000)
                ->assertSee('The language field is required.');
        });
    }

    /**
     * Test Admin click button Close on Popup
     *
     * @return void
     */
    public function testClickCloseOnPopUp() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/languages')
                ->press('#btn-add-language')
                ->assertSee('Language:')
                ->press('Close')
                ->assertDontSee('Language:');
        });
    }

    /**
     * Test Admin click button Add on Popup when data input existed
     *
     * @return void
     */
    public function testClickAddDataExist() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/languages')
                ->press('#btn-add-language')
                ->assertSee('Language:')
                ->type('language', self::LANGUAGE_CREATED)
                ->press('Add')
                ->pause(2000)
                ->assertSee('The language has already been taken.');
        });
    }

    /**
     * Test Admin click button Add on Popup when data input existed
     *
     * @return void
     */
    public function testClickAddDataNotExist() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/languages')
                ->press('#btn-add-language')
                ->assertSee('Language:')
                ->type('language', self::LANGUAGE_NOT_EXIST)
                ->press('Add')
                ->pause(2000)
                ->assertSee('Successfully add the "' . self::LANGUAGE_NOT_EXIST . '" language!');
        });
    }
    /**
     * Make data for test.
     *
     * @return void
     */
    public function makeData()
    {   
        factory(Language::class)->create([
            'language' => self::LANGUAGE_CREATED,
        ]);
    }
}
