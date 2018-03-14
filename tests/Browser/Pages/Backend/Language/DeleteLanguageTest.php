<?php

namespace Tests\Browser\Pages\Backend\Language;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Model\Language;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DeleteLanguageTest extends DuskTestCase
{
    use DatabaseMigrations;

    const NUMBER_RECORD_LANGUAGE = 3;    
    const NO_LANGUAGE_DELETE = 2;

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
     * Test Admin can't see button delete on default language
     *
     * @return void
     */
    public function testDontSeeDeleteButtonOnDefaultLanguage()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/languages');
            $btnDelete = $browser->elements('#list-languages tbody tr:nth-child('.Language::LANGUAGE_DEFAULT.') form button');
            $this->assertCount(0, $btnDelete);
        });
    }

    /**
     * Test Admin click button delete on List Languages
     *
     * @return void
     */
    public function testClickButtonDelete()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/languages')
                    ->click('td button.btn-delete-item')
                    ->assertSee('Confirm deletion!');
        });
    }

    /**
     * Test Admin click button Close on pop up confirmation delete
     *
     * @return void
     */
    public function testClickButtonCloseOnPopup()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/languages')
                    ->click('td button.btn-delete-item')
                    ->assertSee('Confirm deletion!')
                    ->press('Close')
                    ->assertDontSee('Confirm deletion!');
        });
    }

    /**
     * Test Admin click button Delete on pop up confirmation delete
     *
     * @return void
     */
    public function testClickButtonDeleteOnPopup()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/languages');

            $browser->click('#list-languages tbody tr:nth-child('.self::NO_LANGUAGE_DELETE.') button.btn-delete-item')
                    ->press('Delete')
                    ->assertDontSee('Confirm deletion!')
                    ->assertSee('Successfully deleted ');
            // Count row number in one page
            $elements = $browser->elements('#list-languages tbody tr');
            $this->assertCount(self::NUMBER_RECORD_LANGUAGE - 1, $elements);
        });
    }

    /**
     * Make data for test.
     *
     * @return void
     */
    public function makeData()
    {   
        foreach (Language::LANGUAGES as $language) {
            factory(Language::class)->create([
                'language' => $language,
            ]);
        }
    }
}
