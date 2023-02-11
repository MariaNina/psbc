<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradeSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grade_settings', function (Blueprint $table) {
            $table->id();
            $table->string('grade_range', 20);
            $table->string('level_department', 20);
            $table->float('point_equivalent')->nullable();
            $table->string('letter_equivalent', 5)->nullable();
            $table->string('status', 20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grade_settings');
    }
}
