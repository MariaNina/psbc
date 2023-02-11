<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectTblsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_tbls', function (Blueprint $table) {
            $table->id();
            $table->string('subject_name', 50);
            $table->string('subject_code', 10)->unique();
            $table->string('subject_description', 255)->nullable();
            $table->enum('subject_type', ['Acad', 'Non-acad']);
            $table->string('subject_image', 100)->nullable();
            $table->boolean('is_offered');
            $table->boolean('is_for_college')->default(0);
            $table->integer('lect_unit')->unsigned();
            $table->integer('lab_unit')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subject_tbls');
    }
}
