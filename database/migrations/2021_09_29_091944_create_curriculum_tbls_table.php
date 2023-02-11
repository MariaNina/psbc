<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurriculumTblsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curriculum_tbls', function (Blueprint $table) {
            $table->id();
            $table->string('curriculum_year', 30);
            $table->text('curriculum_description')->nullable();
            $table->foreignId('level_id')->references('id')->on('levels_tbls');
            $table->foreignId('program_major_id')->nullable()->references('id')->on('program_majors_tbls')->nullable();
            $table->enum('student_department', ['Elementary', 'JHS','SHS','College','Graduate Studies']);
            $table->foreignId('school_year_id')->references('id')->on('school_year_tbls');
            $table->boolean('is_active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('curriculum_tbls');
    }
}
