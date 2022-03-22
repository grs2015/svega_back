<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNullablesToActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->text('section_description_1')->nullable()->change();
            $table->text('section_description_2')->nullable()->change();
            $table->text('section_description_3')->nullable()->change();
            $table->text('section_description_3')->nullable()->change();
            $table->string('section_title_1')->nullable()->change();
            $table->string('section_title_2')->nullable()->change();
            $table->string('section_title_3')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activities', function (Blueprint $table) {
            //
        });
    }
}
