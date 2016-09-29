<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ships', function (Blueprint $table) {
            $table->increments('id');
            $table->string('shipname');
            $table->integer('length');
            $table->integer('beam');
            $table->integer('height');
            $table->integer('nullmass')->nullable();
            $table->integer('cargocapacity')->nullable()->default(0);
            $table->integer('crew')->default(1);
            $table->integer('powerplant');
            $table->integer('powercount')->nullable();
            $table->integer('primary');
            $table->integer('pcount');
            $table->integer('maneuvering');
            $table->integer('mancount');
            $table->integer('shield');
            $table->integer('shieldcount')->default(0);
            $table->binary('raceenabled')->default(1);
            $table->integer('price')->nullable();
            $table->string('class')->default("Single");
            $table->integer('combatspeed')->nullable();
            $table->integer('combatrating')->nullable();
            $table->integer('waverank')->nullable()->default(0);
            $table->timestamps();
        });
        //Artisan::call('db:seed', array('--class' => 'ShipsTableSeeder'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ships');
    }
}
