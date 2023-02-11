<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentTypeTblsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_type_tbls', function (Blueprint $table) {
            $table->id();
            $table->string('document_name', 50);
            $table->boolean('is_required');
            $table->enum('student_type', ['New', 'Old','Transferee','Cross Enrollee']);
            $table->enum('student_dept', ['Elementary', 'JHS','SHS','College','Graduate Studies']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_type_tbls');
    }
}
