<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditCommentColumnStatusToPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('posts', 'status')) {
            DB::statement('ALTER TABLE `posts` CHANGE COLUMN `status` `status` TINYINT(1) NOT NULL DEFAULT 0 COMMENT "0 is post normal, 1 is find book, 2 is review book"');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('posts', 'status')) {
            DB::statement('ALTER TABLE `posts` CHANGE COLUMN `status` `status` TINYINT(1) NOT NULL DEFAULT 0 COMMENT "0 is not find book, 1 is find book"');
        }
    }
}
