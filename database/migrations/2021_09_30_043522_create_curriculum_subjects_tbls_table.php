<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurriculumSubjectsTblsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curriculum_subjects_tbls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curriculum_id')->references('id')->on('curriculum_tbls');
            $table->foreignId('term_id')->nullable()->references('id')->on('terms_tbls');
            $table->foreignId('subject_id')->references('id')->on('subject_tbls');
            $table->foreignId('prerequisite_subject_id')->nullable()->references('id')->on('subject_tbls');
            $table->boolean('is_offered');
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
        Schema::dropIfExists('curriculum_subjects_tbls');
    }
}
