<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnPageNumberAndRemoveColumnTotalRatingAndRatingToBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->tinyInteger('status')->default(1)->comment('0 is not available, 1 is available')->after('description');
            $table->string('language')->after('author');            
            $table->integer('page_number')->unsigned()->after('language')->nullable();
            $table->dropColumn(['total_rating', 'rating']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['status', 'page_number', 'language']);
            $table->integer('total_rating')->default(0);
            $table->decimal('rating', 4, 1)->default(0);
        });
    }
}
