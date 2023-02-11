<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTblsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts_tbls', function (Blueprint $table) {
            $table->id();
            $table->string('discount_name',50);
            $table->text('discount_description')->nullable();
            $table->string('amount',255);
            $table->string('discount_type',50);
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
        Schema::dropIfExists('discounts_tbls');
    }
}
