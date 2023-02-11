<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTblsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents_tbls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->references('id')->on('students_tbls');
            $table->foreignId('document_type_id')->references('id')->on('document_type_tbls');
            $table->string('document_file', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents_tbls');
    }
}
