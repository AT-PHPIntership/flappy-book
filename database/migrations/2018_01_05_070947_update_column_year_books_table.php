<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColumnYearBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('books', 'year')) {
            DB::statement('ALTER TABLE `books` MODIFY `year` YEAR');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('books', 'year')) {
            DB::statement('ALTER TABLE `books` MODIFY `year` Integer(4)');
        }
    }
}
