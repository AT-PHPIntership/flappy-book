<?php

namespace Tests\Browser\Pages\Backend\Users;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;
use App\Model\User;

class AdminDetailUsersTest extends DuskTestCase
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
         $this->makeUserLogin();
     }

    /**
     * A Dusk test RouteShowDetailUser
     *
     * @return void
     */
    public function testRouteShowDetailUser(){                       
        $user = User::find(1);
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/admin/users')
                    ->assertSee('List Users')
                    ->click('.name-id')
                    ->visit('admin/users/'.$user->id)
                    ->assertSee('Detail User');
        });     
    }

    /**
     * A Dusk test LayoutDetailUser
     *
     * @return void
     */
    public function testLayoutDetailUser()
   {
        $user = User::find(1);
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/admin/users/' . $user->id)
                    ->assertSee('Detail User')
                    ->assertSee('Home')
                    ->assertSee('Users')
                    ->assertSee('User Profile')
                    ->assertSee('Employee Code')
                    ->assertSee('Email')
                    ->assertSee('Role')
                    ->assertSee('Books Donated')
                    ->assertSee('Books Borrowed')
                    ->assertSee('Books Borrowing')
                    ->assertSee('Back');
       });
   }

    /**
     * A Dusk test ShowDetailUser
     *
     * @return void
     */
    public function testShowDetailUser()
   {
        $user = User::find(1);
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/admin/users/' . $user->id);
            $this->assertTrue($browser->text('.profile-username') === $user->name);
            $this->assertTrue($browser->text('.employee_code') === $user->employ_code);
            $this->assertTrue($browser->text('.email') === $user->email);
       });
   }

    /**
     * Make user belong team SA and is admin
     *
     * @return void
     */
    public function makeUserLogin()
    {
        factory(User::class)->create([
            'employ_code' => 'ATI0290',
            'name' => 'Hieu Le T.',
            'email' => 'hieu.le@asiantech.vn',
            'team' => 'SA',
            'is_admin' => User::ROLE_ADMIN,
        ]);
    }
}
