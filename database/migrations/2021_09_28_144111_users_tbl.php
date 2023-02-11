<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UsersTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('users_tbls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->references('id')->on('branch_tbls');
            $table->string('full_name', 200);
            $table->string('user_name', 50)->unique();
            $table->string('password', 255);
            $table->text('salt');
            $table->string('email', 100);
            $table->foreignId('role_id')->references('id')->on('role_tbls');
            $table->date('joined_at')->default(DB::raw('CURRENT_TIMESTAMP'));
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
        //
        Schema::dropIfExists('users_tbls');
    }
}
