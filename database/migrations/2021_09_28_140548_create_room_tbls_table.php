<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomTblsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_tbls', function (Blueprint $table) {
            $table->id();
            $table->string('room_no',10)->unique();
            $table->text('room_description',100)->nullable();
            $table->foreignId('branch_id')->references('id')->on('room_tbls');
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
        Schema::dropIfExists('room_tbls');
    }
}
