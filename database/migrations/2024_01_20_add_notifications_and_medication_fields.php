<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('medications', function (Blueprint $table) {
            // $table->date('start_date')->nullable();
            // $table->date('end_date')->nullable();
            // $table->integer('remaining_doses')->default(0);
            // $table->integer('total_doses')->default(0);
            // $table->boolean('is_active')->default(true);
        });

        // Notifications table creation moved to a later migration to avoid duplicate
        // Schema::create('notifications', function (Blueprint $table) {
        //     $table->uuid('id')->primary();
        //     $table->string('type');
        //     $table->morphs('notifiable');
        //     $table->text('data');
        //     $table->timestamp('read_at')->nullable();
        //     $table->timestamps();
        // });
    }

    public function down()
    {
        // Notifications table is created in a later migration, so don't drop it here.
        Schema::table('medications', function (Blueprint $table) {
            $table->dropColumn([
                'start_date',
                'end_date',
                'remaining_doses',
                'total_doses',
                'is_active'
            ]);
        });
    }
};