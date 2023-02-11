<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevelsTblsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('levels_tbls', function (Blueprint $table) {
            $table->id();
            $table->string('level_code', 10);
            $table->string('level_name', 30);
            $table->enum('student_dept', ['Elementary', 'JHS','SHS','College','Graduate Studies']);
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
        Schema::dropIfExists('levels_tbls');
    }
}
