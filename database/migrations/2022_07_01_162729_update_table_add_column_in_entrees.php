<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableAddColumnInEntrees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entrees', function (Blueprint $table) {
            $table->unsignedBigInteger('facturee_id');
            $table->foreign('facturee_id')
            ->references('id')
            ->on('facturees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entrees', function (Blueprint $table) {
            //
        });
    }
}
