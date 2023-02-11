<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrollmentTblsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrollment_tbls', function (Blueprint $table) {
            $table->id();
            $table->string('application_no',20);
            $table->foreignId('student_id')->references('id')->on('students_tbls');
            $table->foreignId('branch_id')->references('id')->on('branch_tbls');
            $table->foreignId('level_id')->references('id')->on('levels_tbls');
            $table->foreignId('term_id')->nullable()->references('id')->on('terms_tbls');
            $table->foreignId('curriculum_id')->references('id')->on('curriculum_tbls');
            $table->foreignId('school_year_id')->references('id')->on('school_year_tbls');
            $table->foreignId('section_id')->nullable()->references('id')->on('sections_tbls');
            $table->enum('student_department', ['Elementary', 'JHS','SHS','College','Graduate Studies']);
            $table->enum('student_type', ['New', 'Old','Transferee','Cross Enrolee']);
            $table->json('subject_ids')->nullable();
            $table->string('remarks', 255)->nullable();
            $table->boolean('is_approved');
            $table->timestamp('date_submitted');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enrollment_tbls');
    }
}
