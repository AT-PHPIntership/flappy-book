<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('qrcode', 30)->unique();
            $table->integer('category_id')->unsigned();
            $table->string('title');
            $table->text('description');
            $table->tinyInteger('year');
            $table->string('author', 100);
            $table->decimal('price', 15, 2);
            $table->string('unit', 5);
            $table->string('picture');
            $table->string('from_person', 10);
            $table->integer('total_rating')->default(0);
            $table->decimal('rating', 4, 1)->default(0);
            $table->tinyInteger('is_printed')->default(0)->comment('0 is not printed, 1 is printed');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
