<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvVillesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('av_villes', function (Blueprint $table) {
            $table->string('avv_code');
            $table->string('avv_nom');
            $table->string('avv_nom_aeroport');
            $table->timestamps();
            $table->primary('avv_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('av_villes');
    }
}
