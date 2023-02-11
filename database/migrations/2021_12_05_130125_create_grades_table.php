<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->references('id')->on('students_tbls')->onDelete('cascade');
            $table->foreignId('enrollment_id')->constrained()->references('id')->on('enrollment_tbls')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->references('id')->on('subject_tbls')->onDelete('cascade');
            $table->float('grade')->default(0.0);
            $table->string('status',10)->default('ongoing');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grades');
    }
}
