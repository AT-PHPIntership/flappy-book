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
            $table->integer('page_number')->unsigned()->after('author')->nullable();
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
            $table->dropColumn('page_number');
            $table->integer('total_rating')->default(0);
            $table->decimal('rating', 4, 1)->default(0);
        });
    }
}
