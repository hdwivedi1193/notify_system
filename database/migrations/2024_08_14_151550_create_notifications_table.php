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
            $table->unsignedBigInteger('user_id'); // Foreign key for users table
            $table->enum('type', ['marketing', 'invoices', 'system']);
            $table->string('text',255); // Short text field
            $table->timestamp('expiration')->nullable();
            $table->boolean('is_read')->default(false);
            $table->boolean('is_for_all')->default(false); // Indicates if notification is for all users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Foreign key constraint

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
