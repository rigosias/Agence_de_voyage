<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvVolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('av_vols', function (Blueprint $table) {
            $table->string('avo_code_vol');
            $table->string('avo_code_avion');
            $table->string('avo_code_lieu_depart');
            $table->string('avo_code_lieu_destination');
            $table->date('avo_date_depart');
            $table->date('avo_date_arrivee');
            $table->dateTime('avo_heure_depart');
            $table->dateTime('avo_heure_arrivee');
            $table->timestamps();
            $table->primary('avo_code_vol');
            $table->foreign('avo_code_avion')->references('ava_code_avion')->on('av_avions');
            $table->foreign('avo_code_lieu_depart')->references('apv_code_pays_ville')->on('av_pays_villes');
            $table->foreign('avo_code_lieu_destination')->references('apv_code_pays_ville')->on('av_pays_villes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('av_vols');
    }
}
