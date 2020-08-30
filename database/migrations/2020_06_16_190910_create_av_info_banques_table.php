<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvInfoBanquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('av_info_banques', function (Blueprint $table) {
            $table->string('avib_no_compte');
            $table->integer('id_user');
            $table->integer('avib_cvc');
            $table->date('avib_date_expiration');
            $table->decimal('avib_solde', 8, 2);
            $table->timestamps();
            $table->primary('avib_no_compte');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('av_info_banques');
    }
}
