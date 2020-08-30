<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToAvVols extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('av_vols', function (Blueprint $table) {
            $table->decimal('avo_prix_billet', 8, 2)->after('avo_heure_arrivee');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('av_vols', function (Blueprint $table) {
            $table->dropColumn('avo_prix_billet');
        });
    }
}
