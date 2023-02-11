<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTblsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_tbls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->references('id')->on('users_tbls');
            $table->foreignId('guardian_id')->references('id')->on('guardian_tbls');
            $table->string('first_name', 30);
            $table->string('middle_name', 30)->nullable();
            $table->string('last_name', 30);
            $table->string('suffix_name', 5)->nullable();
            $table->string('email');
            $table->enum('student_type', ['New', 'Old', 'Transferee', 'Cross Enrolee']);
            $table->string('lrn', 30)->nullable();
            $table->date('birth_day');
            $table->string('birth_place', 100)->nullable();
            $table->enum('gender', ['Male', 'Female']);
            $table->string('citizenship', 30)->nullable();
            $table->enum('civil_status', ['Single', 'Married', 'Divorced', 'Anulled ', 'Separated', 'Widowed']);
            $table->string('address', 100);
            $table->string('religion', 30)->nullable();
            $table->string('contact_number', 20)->nullable()->default("N/A");
            $table->string('image', 255)->nullable();
            $table->text('other_details')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students_tbls');
    }
}
