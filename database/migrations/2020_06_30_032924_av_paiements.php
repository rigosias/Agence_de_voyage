<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AvPaiements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('av_paiements', function (Blueprint $table) {
            $table->string('avpa_code_paiement');
            $table->decimal('avpa_montant_paiement', 8, 2);
            $table->dateTime('avpa_date_paiement');
            $table->string('avpa_statut');
            $table->dateTime('avpa_date_renversement');
            $table->string('avpa_no_compte');
            $table->timestamps();
            $table->primary('avpa_code_paiement');
            $table->foreign('avpa_no_compte')->references('avib_no_compte')->on('av_info_banques');
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
