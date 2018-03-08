<?php

namespace Tests\Browser\Pages\Backend\Qrcodes;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Model\User;
use App\Model\Category;
use App\Model\Book;
use App\Model\Qrcode;
use Faker\Factory as Faker;

class ListQrcodesAndDownloadTest extends DuskTestCase
{
    use DatabaseMigrations;

    const NUMBER_RECORD_CREATE = 18;

    /**
     * A Dusk test show view list qrcodes.
     *
     * @return void
     */
    public function testListQrcodes()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin')
                ->clickLink('Qrcodes')
                ->assertPathIs('/admin/qrcodes')
                ->assertSee('List Qrcodes');
        });
    }

    /**
     * A Dusk test list qrcodes if empty data qrcodes
     *
     * @return void
     */
    public function testListQrcodesEmpty()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/qrcodes')
                ->assertSee('List Qrcodes')
                ->assertDontSee('Download');
        });
    }

    /**
     * A Dusk test show record with table qrcodes has data.
     *
     * @return void
     */
    public function testShowRecord()
    {
        $this->makeData(4);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/qrcodes');
            $elements = $browser->elements('#list-qrcodes tbody tr');
            $this->assertCount(4, $elements);
        });
    }

    /**
     * A Dusk test view Admin List Qrcodes with pagination
     *
     * @return void
     */
    public function testListQrcodesPagination()
    {
        $this->makeData(self::NUMBER_RECORD_CREATE);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/qrcodes');
            $elements = $browser->elements('#list-qrcodes tbody tr');
            $this->assertCount(config('define.qrcodes.limit_rows'), $elements);
            $this->assertNotNull($browser->element('.pagination'));
            $paginate_element = $browser->elements('.pagination li');
            $number_page = count($paginate_element) - 2;
            $this->assertTrue($number_page == ceil((self::NUMBER_RECORD_CREATE + 1) / (config('define.qrcodes.limit_rows'))));
        });
    }

    /**
     * A Dusk test view Admin List Qrcodes with lastest pagination
     *
     * @return void
     */
    public function testPathPagination()
    {
        $this->makeData(self::NUMBER_RECORD_CREATE);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/qrcodes?page=' . ceil((self::NUMBER_RECORD_CREATE + 1) / (config('define.qrcodes.limit_rows'))));
            $elements = $browser->elements('#list-qrcodes tbody tr');
            $browser->assertPathIs('/admin/qrcodes')
                ->assertQueryStringHas('page', ceil((self::NUMBER_RECORD_CREATE + 1) / (config('define.qrcodes.limit_rows'))));
        });
    }

    /**
     * A Dusk test click download List Qrcodes success
     *
     * @return void
     */
    public function testClickDownloadQrcodeSuccess()
    {
        $this->makeData(self::NUMBER_RECORD_CREATE);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('admin/qrcodes')
                ->assertSee('Download')
                ->press('Download')
                ->pause(4000)
                ->visit('admin/qrcodes')
                ->assertDontSee('Download');
        });
    }

    /**
     * A Dusk test click download List Qrcodes fail
     *
     * @return void
     */
    public function testClickDownloadFail()
    {
        $this->makeData(self::NUMBER_RECORD_CREATE);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('admin/qrcodes')
                ->assertSee('Download')
                ->press('Download')
                ->pause(4000)
                ->press('Download')
                ->assertSee('Data Empty')
                ->assertDontSee('Download');
        });
    }

    /**
     * A Data test for users, books and qrcodes
     *
     * @return void
     */
    public function makeData($row)
    {
        $faker = Faker::create();
        $users = factory(User::class, 4)->create();
        $employeeCodes = $users->pluck('employ_code')->toArray();
        $categoryIds = factory(Category::class, 2)->create()->pluck('id')->toArray();
        for ($i = 0; $i < $row; $i++) {
            $books[] = factory(Book::class)->create([
                'from_person' => $faker->randomElement($employeeCodes),
                'category_id' => $faker->randomElement($categoryIds),
            ]);
        }
        $bookIds = array_pluck($books, 'id');
        for ($i = 0; $i < $row; $i++) {
            factory(Qrcode::class)->create([
                'book_id' => $faker->randomElement($bookIds),
                'status' => Qrcode::IS_NOT_PRINTED,
            ]);
        }
    }
}
