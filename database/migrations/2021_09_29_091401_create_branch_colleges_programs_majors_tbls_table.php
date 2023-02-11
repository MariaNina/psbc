<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchCollegesProgramsMajorsTblsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_colleges_programs_majors_tbls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->references('id')->on('branch_tbls');
            $table->foreignId('college_id')->references('id')->on('colleges_tbls');
            $table->foreignId('program_major_id')->references('id')->on('program_majors_tbls');
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
        Schema::dropIfExists('branch_colleges_programs_majors_tbls');
    }
}
