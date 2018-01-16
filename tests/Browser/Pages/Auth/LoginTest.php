<?php

namespace Tests\Browser\Pages\Auth;
use App\Model\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test route Login.
     *
     * @return void
     */
    public function testLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->logout();
            $browser->visit('/')
                    ->clickLink('Login')
                    ->assertSee('Sign in to start your session')
                    ->assertPathIs('/login');
        });
    }

    /**
     * List case for Test Validation Login
     *
     */
    public function listCaseForTestValidateogin()
    {
        return [
            ['', '', ['The email field is required.',
                      'The password field is required.']],
            ['abc.xyz@asiantech.vn', '', ['The password field is required.']],
            ['', 'abcxyz', ['The email field is required.']],
            ['abc.xyzasiantech.vn', 'password', ['The email must be a valid email address.']],
            ['abc.xyz@asiantech.vn', 'password', ['Email or password not correct']],
        ];
    }

     /**
     * 
     * @dataProvider listCaseForTestValidateogin
     *
     */   
    public function testValidateLogin($email, $password, $expected)
    {   
        $this->browse(function (Browser $browser) use ($email, $password, $expected)
        {   
            $browser->logout();
            $browser->visit('/login')
                ->type('email', $email)
                ->type('password', $password)
                ->press('Sign In');
                foreach ($expected as $value) {
                    $browser->assertSee($value);
                }
                $browser->assertPathIs('/login');
        });
    }

    /**
    * List case for Test  Login success
    *
    */
    public function listCaseForTestLogin()
    {
        return [
            ['hieu.le@asiantech.vn', 'Hieu12589'],
        ];
    }

    /**
     * 
     * @dataProvider listCaseForTestLogin
     *
     */   
    public function testUserLoginSuccess($email, $password)
    {   
        $this->browse(function (Browser $browser) use ($email, $password)
        {   
            $browser->logout();
            $browser->visit('/login')
                    ->assertPathIs('/login')
                    ->type('email', $email)
                    ->type('password', $password)
                    ->press('Sign In')
                    ->assertPathIs('/');
        });
    }

    /**
     * Test Route page of Admin when login success with account user.
     *
     * @return void
     */
    public function testUserLoginRoutePageAdmin()
    {   
        $this->makeUserLogin();
        $this->browse(function (Browser $browser)  {
            $browser->loginAs(User::find(1));
            $browser->visit('/admin')
                    ->assertSee('Forbidden')
                    ->assertPathIs('/admin')
                    ->waitForLocation('/', 5);
        });
    }

    /**
     * Test Route page of Admin when guest account.
     *
     * @return void
     */
    public function testGuestRoutePageAdmin()
    {   
        $this->browse(function (Browser $browser)  {
            $browser->logout();
            $browser->visit('/admin')
                    ->assertSee('Sign in to start your session')
                    ->assertPathIs('/login');
        });
    }

    /**
    * Make user belong team PHP
    *
    * @return void
    */
    public function makeUserLogin()
    {
        factory(User::class, 1)->create([
            'employ_code' => 'ATI0297',
            'name' => 'Minh Dao T.',
            'email' => 'minh.dao@asiantech.vn',
            'team' => 'PHP',
            'is_admin' => '0',
        ]);
    }   
}
