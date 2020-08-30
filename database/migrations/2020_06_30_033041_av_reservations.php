<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AvReservations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('av_reservations', function (Blueprint $table) {
            $table->string('avr_code_reservation');
            $table->integer('id_user');
            $table->dateTime('avr_date_reservation');
            $table->string('avr_code_vol');
            $table->dateTime('avr_date_annulation')->nullable();
            $table->string('avr_statut_reservation')->nullable();
            $table->string('avr_code_paiement');
            $table->string('avr_statut_paiement')->nullable();
            $table->timestamps();
            $table->primary('avr_code_reservation');
            $table->foreign('avr_code_vol')->references('avo_code_vol')->on('av_vols');
            $table->foreign('avr_code_paiement')->references('avpa_code_paiement')->on('av_paiements');
            //$table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
