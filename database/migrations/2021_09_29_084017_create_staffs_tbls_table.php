<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffsTblsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staffs_tbls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users_tbls');
            $table->string('csc_id', 100)->nullable()->default('N/A');
            $table->string('first_name', 30);
            $table->string('middle_name', 30)->nullable();
            $table->string('last_name', 30);
            $table->string('extension_name', 5)->nullable();
            $table->enum('staff_type', ['Admin', 'Academic', "Janitor/Guard"])->nullable();
            $table->string('position', 30)->nullable();
            $table->string('Department', 100)->nullable();
            $table->foreignId('major_in')->nullable()->references('id')->on('subject_tbls');
            $table->string('licence_number', 100)->nullable();
            $table->boolean('is_masteral')->nullable();
            $table->date('birth_day')->nullable();
            $table->string('birth_place', 100)->nullable()->default("Not set");
            $table->enum('gender', ['Male', 'Female'])->nullable();
            $table->enum('civil_status', ['Single', 'Married', 'Separated', 'Widowed'])->nullable();
            $table->bigInteger('height_m')->nullable();
            $table->bigInteger('weight_kg')->nullable();
            $table->enum('blood_type', ['A', 'B', 'AB', 'O'])->nullable();
            $table->string('gsis', 30)->nullable()->default("Not set");
            $table->string('pagibig', 30)->nullable()->default("Not set");
            $table->string('sss', 30)->nullable()->default("Not set");
            $table->string('tin', 30)->nullable()->default("Not set");
            $table->string('phil_health', 30)->nullable()->default("Not set");
            $table->string('agency_employee_no', 30)->nullable()->default("Not set");
            $table->string('citizenship', 30)->nullable()->default("Not set");
            $table->string('address', 100)->nullable();
            $table->bigInteger('zip_code')->nullable();
            $table->string('telephone_number', 20)->nullable()->default("N/A");
            $table->string('mobile_number', 20)->nullable()->default("N/A");
            $table->string('image', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staffs_tbls');
    }
}
