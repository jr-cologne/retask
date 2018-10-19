<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeforeDeleteTriggerOnUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            CREATE TRIGGER `users_before_delete`
            BEFORE DELETE
            ON `users` FOR EACH ROW
            BEGIN
                DELETE FROM `tasks` WHERE `user_id` = `OLD`.`id`;
                DELETE FROM `task_lists` WHERE `user_id` = `OLD`.`id`;
            END;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP TRIGGER `users_before_delete`;");
    }
}
