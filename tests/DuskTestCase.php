<?php

namespace Tests;

use App\Model\User;
use Faker\Factory as Faker;
use Laravel\Dusk\TestCase as BaseTestCase;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Logged in user
     *
     * @var App\Model\User
     */
    protected $user;
    /**
     * Override function setUp() for make user login
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->user = $this->createAdminUser();
    }

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        static::startChromeDriver();
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        $options = (new ChromeOptions)->addArguments([
            '--disable-gpu',
            '--headless'
        ]);

        return RemoteWebDriver::create(
            'http://localhost:9515', DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY, $options
            )
        );
    }

    /**
     * Make user belong team SA and is admin
     *
     * @return void
     */
    public function createAdminUser()
    {
        return factory(User::class)->create([
            'employ_code' => 'ATI0297',
            'name' => 'Minh Dao T.',
            'email' => 'minh.dao@asiantech.vn',
            'team' => User::ADMIN_TEAM_NAME,
            'is_admin' => User::ROLE_ADMIN,
        ]);
    }
}

