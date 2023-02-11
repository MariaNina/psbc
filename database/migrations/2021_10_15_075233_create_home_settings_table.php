<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();

            $table->string('contact_no')->nullable();
            $table->string('email')->nullable();
            $table->string('facebook')->nullable();

            $table->string('carousel_img1')->nullable();
            $table->string('carousel_img2')->nullable();
            $table->string('carousel_img3')->nullable();

            $table->string('carousel_title')->nullable();
            $table->text('carousel_subtitle')->nullable();
            $table->string('carousel_link1')->nullable();
            $table->string('carousel_link2')->nullable();

            $table->string('home_icon_title1')->nullable();
            $table->text('home_icon_subtitle1')->nullable();

            $table->string('home_icon_title2')->nullable();
            $table->text('home_icon_subtitle2')->nullable();

            $table->string('home_icon_title3')->nullable();
            $table->text('home_icon_subtitle3')->nullable();

            $table->string('home_announcement_img_background')->nullable();

            $table->string('campus_title')->nullable();
            $table->text('campus_subtitle')->nullable();

            // campus images

            $table->string('offer_title')->nullable();
            $table->string('offer_img')->nullable();
            $table->text('offer_subtitle')->nullable();
            $table->text('offer_list')->nullable();


            $table->string('program_pagetitle')->nullable();
            $table->string('program_contentitle')->nullable();

            // is_maintenance
            $table->boolean('is_maintenance')->default(0)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('home_settings');
    }
}
