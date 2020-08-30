<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvPaysVillesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('av_pays_villes', function (Blueprint $table) {
            $table->string('apv_code_pays_ville');
            $table->string('apv_code_pays');
            $table->string('apv_code_ville');
            $table->timestamps();
            $table->primary('apv_code_pays_ville');
            $table->foreign('apv_code_pays')->references('avp_code')->on('av_pays');
            $table->foreign('apv_code_ville')->references('avv_code')->on('av_villes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('av_pays_villes');
    }
}
