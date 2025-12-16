<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('medications', function (Blueprint $table) {
            $table->boolean('is_active')->default(true);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('remaining_doses')->default(0);
            $table->integer('total_doses')->default(0);
        });
    }

    public function down()
    {
        Schema::table('medications', function (Blueprint $table) {
            $table->dropColumn([
                'is_active',
                'start_date',
                'end_date',
                'remaining_doses',
                'total_doses'
            ]);
        });
    }
};