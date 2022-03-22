<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mains', function (Blueprint $table) {
            $table->increments('id');
            $table->string('main_title');
            $table->string('main_image')->nullable();
            $table->string('parallax_images')->nullable();
            $table->string('company_name');
            $table->string('company_data');
            $table->string('address');
            $table->string('phone', 100);
            $table->string('email', 100);
            $table->string('website', 100);

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
        Schema::dropIfExists('mains');
    }
}
