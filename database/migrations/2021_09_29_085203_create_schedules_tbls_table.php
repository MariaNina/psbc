<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTblsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules_tbls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->references('id')->on('branch_tbls');
            $table->foreignId('term_id')->nullable()->references('id')->on('terms_tbls');
            $table->foreignId('staff_id')->references('id')->on('staffs_tbls');
            $table->foreignId('section_id')->references('id')->on('sections_tbls');
            $table->foreignId('subject_id')->references('id')->on('subject_tbls');
            $table->foreignId('room_id')->references('id')->on('room_tbls');
            $table->string('days', 100);
            $table->time('start_time');
            $table->time('end_time');
            $table->string('room_days_time', 50)->unique();
            $table->string('teacher_days_time', 50)->unique();
            $table->string('section_days_time', 50)->unique();
            $table->string('section_subject', 50)->unique();
            $table->foreignId('school_year_id')->references('id')->on('school_year_tbls');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules_tbls');
    }
}
