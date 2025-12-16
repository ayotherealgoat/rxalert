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
        // This migration used to create the medications table; convert it to add columns
        // to support dosing schedule without re-creating the table.
        Schema::table('medications', function (Blueprint $table) {
            if (!Schema::hasColumn('medications', 'times_per_day')) {
                $table->integer('times_per_day')->default(1);
            }

            if (!Schema::hasColumn('medications', 'first_dose_time')) {
                $table->time('first_dose_time')->nullable();
            }

            if (!Schema::hasColumn('medications', 'dose_interval')) {
                $table->integer('dose_interval')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medications', function (Blueprint $table) {
            $table->dropColumn(['times_per_day', 'first_dose_time', 'dose_interval']);
        });
    }
};
