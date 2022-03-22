<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('subtitle');
            $table->string('section_title_1');
            $table->text('section_description_1');
            $table->string('section_title_2');
            $table->text('section_description_2');
            $table->string('section_title_3');
            $table->text('section_description_3');
            $table->string('image')->nullable();
            $table->unsignedInteger('main_id');

            $table->foreign('main_id')->references('id')->on('mains');
            $table->softDeletes();

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
        Schema::dropIfExists('activities');
    }
}
