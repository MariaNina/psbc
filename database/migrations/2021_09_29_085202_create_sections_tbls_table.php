<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionsTblsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections_tbls', function (Blueprint $table) {
            $table->id();
            $table->string('section_label', 10);
            $table->boolean('hasSchedule')->nullable()->default(false);
            $table->foreignId('adviser_id')->references('id')->on('staffs_tbls');
            $table->foreignId('school_year_id')->references('id')->on('school_year_tbls');
            $table->foreignId('level_id')->references('id')->on('levels_tbls');
            $table->foreignId('branch_id')->references('id')->on('branch_tbls');
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
        Schema::dropIfExists('sections_tbls');
    }
}
