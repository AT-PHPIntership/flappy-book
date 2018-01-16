<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateIsAdminToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('users', 'is_admin')) {
            DB::statement('ALTER TABLE `users` CHANGE `is_admin` `is_admin` TINYINT(4) DEFAULT 0 NOT NULL');
        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('users', 'is_admin')) {
            DB::statement('ALTER TABLE `users` CHANGE `is_admin` `is_admin` TINYINT(4) NULL');
        }
    }
}
