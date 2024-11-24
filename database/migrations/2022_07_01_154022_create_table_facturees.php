<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFacturees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('depot_id');
            $table->unsignedBigInteger('fournisseur_id');
            $table->foreign('depot_id')
            ->references('id')
            ->on('depots');
            $table->foreign('fournisseur_id')
            ->references('id')
            ->on('fournisseurs');
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
        Schema::dropIfExists('facturees');
    }
}
