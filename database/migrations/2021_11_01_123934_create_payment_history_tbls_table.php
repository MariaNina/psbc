<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentHistoryTblsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_history_tbls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->references('id')->on('students_tbls');
            $table->foreignId('assessments_id')->references('id')->on('assessments_tbls');
            $table->string('payment_method',50);
            $table->double('payment_amount', 100, 2);
            $table->double('amount_received', 100, 2)->nullable();
            $table->double('amount_change', 100, 2)->nullable();
            $table->text('payment_proof')->nullable();
            $table->boolean('is_approved');
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
        Schema::dropIfExists('payment_history_tbls');
    }
}
