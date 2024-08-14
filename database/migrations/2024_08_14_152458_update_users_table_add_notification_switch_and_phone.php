<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTableAddNotificationSwitchAndPhone extends Migration
{
    /**
     * Run the migrations to add new columns to the users table.
     *
     * This method modifies the existing users table by adding a 'notification_switch' column
     * that is not nullable and a 'phone_number' column that is nullable.
     * It also sets a default value for the 'notification_switch' column.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('notification_switch')->default(true)->after('user_type');
            $table->string('phone_number')->nullable()->after('notification_switch');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the 'notification_switch' and 'phone_number' columns
            $table->dropColumn(['notification_switch', 'phone_number']);

        });
    }
}
