<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchTblsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_tbls', function (Blueprint $table) {
            $table->id();
            $table->string('branch_name', 20)->unique();
            $table->string('branch_address', 100)->unique();
            $table->text('description')->nullable();
            $table->string('email', 60);
            $table->string('telephone_no', 30);
            $table->string('mobile_no', 15);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branch_tbls');
    }
}
