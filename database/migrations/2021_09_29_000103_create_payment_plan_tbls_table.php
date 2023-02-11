<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentPlanTblsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_plan_tbls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->references('id')->on('students_tbls');
            $table->enum('payment_plan_type', ['Cash', 'Installment']);
            $table->json('discounts')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_plan_tbls');
    }
}
