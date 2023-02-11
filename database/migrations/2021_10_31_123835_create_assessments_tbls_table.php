<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentsTblsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessments_tbls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->references('id')->on('students_tbls');
            $table->foreignId('enrollment_id')->references('id')->on('enrollment_tbls');
            $table->json('fees')->nullable(); //tuition_fees
            $table->json('other_fees')->nullable();
            $table->json('discounts')->nullable();
            $table->json('interest')->nullable();
            $table->enum('payment_type', ['Full Payment', 'Installment'])->nullable();
            $table->enum('student_department', ['Elementary', 'JHS','SHS','College','Graduate Studies']);
            $table->double('fee_amount', 100, 2)->nullable();
            $table->enum('status', ['paid', 'pending'])->nullable();
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
        Schema::dropIfExists('assessments_tbls');
    }
}
