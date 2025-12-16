<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('due_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reminder_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('notified_at');
            $table->timestamps();
        });
    }

//     public function up()
// {
//     Schema::create('medications', function (Blueprint $table) {
//         // ...existing columns...
//         $table->time('first_dose_time');
//         $table->integer('times_per_day');
//         $table->integer('hours_between_doses')->nullable();
//         $table->json('custom_dose_times')->nullable(); // For custom scheduling
//         $table->timestamps();
//     });
// }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('due_notifications');
    }
};
