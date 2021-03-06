<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('username')->unique();
            $table->string('game_handle');
            $table->string('email')->unique()->nullable();
            $table->string('password');
            $table->integer('organization_id')->nullable();
            $table->integer('fleet_id')->nullable();
            $table->integer('squad_id')->nullable();
            $table->integer('station_id')->nullable();
            $table->integer('active_ship')->nullable();
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
