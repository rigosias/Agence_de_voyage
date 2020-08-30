<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvAvionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('av_avions', function (Blueprint $table) {
            $table->string('ava_code_avion');
            $table->string('ava_code_compagnie');
            $table->integer('ava_nbre_place');
            $table->integer('ava_nbre_place_economique');
            $table->integer('ava_nbre_place_premiere');
            $table->string('ava_type');
            $table->tinyInteger('ava_nourriture')->default('0');
            $table->boolean('ava_prise_electrique')->default('0');
            $table->boolean('ava_wifi')->default('0');
            $table->boolean('ava_chaise_pliante')->default('0');
            $table->timestamps();
            $table->primary('ava_code_avion');
            $table->foreign('ava_code_compagnie')->references('avc_code')->on('av_compagnies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('av_avions');
    }
}
