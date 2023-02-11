<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramMajorsTblsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_majors_tbls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->references('id')->on('programs_tbls');
            $table->foreignId('major_id')->references('id')->on('majors_tbls');
            $table->text('description')->nullable();
            $table->enum('student_department', ['Elementary', 'JHS','SHS','College','Graduate Studies']);
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
        Schema::dropIfExists('program_majors_tbls');
    }
}
