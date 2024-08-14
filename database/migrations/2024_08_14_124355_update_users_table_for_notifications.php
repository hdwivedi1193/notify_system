<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTableForNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Apply the migration to update the 'users' table.
         *
         * This method adds new columns to the 'users' table:
         * - 'notification_switch': A boolean flag to toggle notifications.
         * - 'phone_number': A nullable field to store user's phone number.
         * - 'user_type': A string field to identify the type of user, defaulting to 'individual'.
         */

        Schema::table('users', function (Blueprint $table) {
            $table->boolean('notification_switch')->default(false)->after('email_verified_at');
            $table->string('phone_number')->nullable()->after('notification_switch');
            $table->string('user_type')->default("individual")->after('phone_number');

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
            $table->dropColumn('notification_switch');
            $table->dropColumn('phone_number');
            $table->dropColumn('user_type');

        });
    }
}
