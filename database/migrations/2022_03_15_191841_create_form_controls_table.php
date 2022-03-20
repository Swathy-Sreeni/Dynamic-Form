<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormControlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_controls', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label')->nullable();
            $table->tinyInteger('type')->default(1)->comment('1: Text 2 : Number 3 : Select');
            $table->integer('form_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('form_id')->references('id')->on('forms')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_controls');
    }
}
