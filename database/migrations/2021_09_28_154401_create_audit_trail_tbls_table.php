<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditTrailTblsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_trail_tbls', function (Blueprint $table) {
            $table->string('module', 100);
            $table->longText('description');
            $table->string('action_taken', 10);
            $table->foreignId('user_id')->references('id')->on('users_tbls');
            $table->timestamp('datetime');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audit_trail_tbls');
    }
}
