<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableAddColumnInSorties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sorties', function (Blueprint $table) {
            $table->unsignedBigInteger('facture_id');
            $table->foreign('facture_id')
            ->references('id')
            ->on('factures');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sorties', function (Blueprint $table) {
            //
        });
    }
}
