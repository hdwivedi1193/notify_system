<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations to create the notifications table.
     * This method sets up the structure for the notifications table. 
     * It includes fields for notification ID, user ID (foreign key), 
     * text, type, expiration, read status, and whether the notification is for all users.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['marketing', 'invoices', 'system']);
            $table->string('text',255); // Short text field
            $table->timestamp('expiration')->nullable();
            $table->enum('destination', ['all', 'specific'])->default("all");

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
        Schema::dropIfExists('notifications');
    }
}
