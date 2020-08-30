<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvPaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('av_pays', function (Blueprint $table) {
            $table->string('avp_code');
            $table->string('avp_nom');
            $table->string('avp_nationalite');
            $table->timestamps();
            $table->primary('avp_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('av_pays');
    }
}
