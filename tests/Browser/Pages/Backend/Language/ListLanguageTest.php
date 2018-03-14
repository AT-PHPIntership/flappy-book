<?php

namespace Tests\Browser\Pages\Backend\Language;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Model\Language;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;

class ListLanguageTest extends DuskTestCase
{
    use DatabaseMigrations;

    const DEFAULT_LANGUAGE = 'Default Language';
    const NUMBER_RECORD_CREATE = 13;

    /**
     * Override function setUp()
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        factory(Language::class)->create([
            'language' => self::DEFAULT_LANGUAGE
        ]);
    
        foreach (Language::LANGUAGES as $language) {
            factory(Language::class)->create([
                'language' => $language,
        ]);
    }
    }

    /**
     * A Dusk test show view list languages.
     *
     * @return void
     */
    public function testListLanguages()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->resize(1200,1600)
                    ->visit('/admin')
                    ->clickLink('Languages')
                    ->assertPathIs('/admin/languages')
                    ->assertSee('List Languages');
        });
    }

    /**
     * A Dusk test show record with table languages has data.
     *
     * @return void
     */
    public function testShowRecord()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->resize(1200,1600)
                    ->visit('/admin/languages');
            $elements = $browser->elements('#list-languages tbody tr');
            $this->assertCount(4, $elements);
            $this->assertNull($browser->element('.pagination'));
        });
    }

    /**
     * A Dusk test view Admin List languages with pagination
     *
     * @return void
     */
    public function testListLanguagesPagination()
    {
        $this->makeData(self::NUMBER_RECORD_CREATE);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->resize(1200,1600)
                    ->visit('/admin/languages');
            $elements = $browser->elements('#list-languages tbody tr');
            $this->assertCount(config('define.languages.limit_rows'), $elements);
            $this->assertNotNull($browser->element('.pagination'));
            $paginate_element = $browser->elements('.pagination li');
            $number_page = count($paginate_element) - 2;
            $this->assertTrue($number_page == ceil((self::NUMBER_RECORD_CREATE + 4) / (config('define.languages.limit_rows'))));
        });
    }

    /**
     * A Dusk test view Admin List languages with lastest pagination
     *
     * @return void
     */
    public function testPathPagination()
    {
        $this->makeData(self::NUMBER_RECORD_CREATE);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->resize(1200,1600)
                    ->visit('/admin/languages?page='.ceil((self::NUMBER_RECORD_CREATE + 4) / (config('define.languages.limit_rows'))));
            $browser->assertPathIs('/admin/languages')
                    ->assertQueryStringHas('page', ceil((self::NUMBER_RECORD_CREATE + 4) / (config('define.languages.limit_rows'))));
        });
    }

    /**
     * A Dusk test view Admin List languages at last page
     *
     * @return void
     */
    public function testNumberRecordLastPage()
    {
        $this->makeData(self::NUMBER_RECORD_CREATE);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->resize(1200,1600)
                    ->visit('/admin/languages?page='.ceil((self::NUMBER_RECORD_CREATE + 4) / (config('define.languages.limit_rows'))));
            $elements = $browser->elements('#list-languages tbody tr');
            $this->assertCount((self::NUMBER_RECORD_CREATE + 4) % config('define.languages.limit_rows') == 0 ? config('define.languages.limit_rows') : (self::NUMBER_RECORD_CREATE + 4) % config('define.languages.limit_rows'), $elements);
        });
    }

    /**
     * A Data test for languages
     *
     * @return void
     */
    public function makeData($row)
    {
        $faker = Faker::create();
        
        factory(Language::class, $row)->create([
            'language' => $faker->name,
        ]);
    }
}
