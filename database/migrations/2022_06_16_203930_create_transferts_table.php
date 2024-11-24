<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transferts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produit_id');
            $table->unsignedBigInteger('depot_id');
            $table->unsignedBigInteger('destinataire_id');
            $table->double('quantite');
            $table->string('destinataire');
            $table->foreign('produit_id')
            ->references('id')
            ->on('produits');
            $table->foreign('depot_id')
            ->references('id')
            ->on('depots');
            $table->foreign('destinataire_id')
            ->references('id')
            ->on('depots');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transferts');
    }
}
