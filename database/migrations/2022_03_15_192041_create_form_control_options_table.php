<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormControlOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_control_options', function (Blueprint $table) {
            $table->increments('id');
            $table->string('option')->nullable();
            $table->integer('form_control_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('form_control_id')->references('id')->on('form_controls')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_control_options');
    }
}
