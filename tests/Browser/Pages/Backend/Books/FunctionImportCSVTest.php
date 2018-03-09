<?php

namespace Tests\Browser\Pages\Backend\Books;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Model\Book;

class FunctionImportCSVTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test validate required function import csv.
     *
     * @return void
     */
    public function testValidateRequiredFunctionImportCSV()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->resize(1920, 1080)
                ->visit('/admin/books')
                ->press('Import Data')
                ->press('Import')
                ->pause(1000)
                ->assertSee('The file field is required.');
        });
    }

    /**
     * A Dusk test validate type function import csv.
     *
     * @return void
     */
    public function testValidateTypeFunctionImportCSV()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->resize(1920, 1080)
                ->visit('/admin/books')
                ->press('Import Data')
                ->attach('file', base_path() . "/tests/files/csv/AT-Book List Type.xlsx")
                ->press('Import')
                ->pause(1000)
                ->assertSee('Only support csv file type');
        });
    }

    /**
     * A Dusk test fuction import csv success.
     *
     * @return void
     */
    public function testFunctionImportCSVSuccess()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('admin/books')
                ->resize(1920, 1080)
                ->press('Import Data')
                ->attach('file', base_path() . "/tests/files/csv/AT-Book List Success.csv")
                ->press('Import')
                ->pause(5000)
                ->assertSee('Import Book Success!');
                
            $totalRecord = Book::count();
            $bookRow = $browser->elements('#list-books tbody tr');
            $this->assertCount($totalRecord, $bookRow);
        });
    }

    /**
     * A Dusk test fuction import csv fail.
     *
     * @return void
     */
    public function testFunctionImportCSVFail()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('admin/books')
                ->resize(1920, 1080)
                ->press('Import Data')
                ->attach('file', base_path() . "/tests/files/csv/AT-Book List Fail.csv")
                ->press('Import')
                ->pause(5000)
                ->assertSee('Import Book Fail!');
        });
    }
}
