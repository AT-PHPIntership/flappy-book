<?php

namespace Tests\Browser\Pages\Backend\Users;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;
use App\Model\User;

class ListUsersTest extends DuskTestCase
{
    use DatabaseMigrations;

    const NUMBER_RECORD_CREATE = 25;

    /**
    * Override function setUp() for make user login
    *
    * @return void
    */
    public function setUp()
    {
        parent::setUp();

        $this->createAdminUser();
        factory(User::class, self::NUMBER_RECORD_CREATE)->create();
    }

    /**
    * A Dusk test list users.
    *
    * @return void
    */
    public function testRoute()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                    ->visit('/admin')
                    ->clickLink('Users')
                    ->assertPathIs('/admin/users')
                    ->assertSee('List Users');
        });
    }

    /**
    * A Dusk test show record with table has data.
    *
    * @return void
    */
    public function testShowRecord()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                    ->visit('/admin/users')
                    ->assertSee('List Users');
            $elements = $browser->elements('#list-users tbody tr');
            $this->assertCount(config('define.users.limit_rows'), $elements);
        });
    }

    /**
    * Test view Admin List Users with pagination
    *
    * @return void
    */
    public function testPagination()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                    ->visit('/admin/users')
                    ->assertSee('List Users');
            //Count page number of pagination
            $paginate_element = $browser->elements('.pagination li');
            $number_page = count($paginate_element)- 2;
            $this->assertTrue($number_page == ceil((self::NUMBER_RECORD_CREATE + 1) / (config('define.users.limit_rows'))));
        });
    }

    /**
    * Test click page 2 in pagination link
    *
    * @return void
    */
    public function testPathPagination()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                    ->visit('/admin/users?page='.ceil((self::NUMBER_RECORD_CREATE + 1) / (config('define.users.limit_rows'))))
                    ->assertSee('List Users');
            $browser->assertQueryStringHas('page', ceil((self::NUMBER_RECORD_CREATE + 1) / (config('define.users.limit_rows'))));
        });
    }
}
