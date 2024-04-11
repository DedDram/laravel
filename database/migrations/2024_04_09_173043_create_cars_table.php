<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('vin');
            $table->string('brand');
            $table->string('model');
            $table->integer('year')->default(0)->unsigned();
            $table->string('color');
            $table->integer('mileage')->default(0)->unsigned();
            $table->string('kpp');
            $table->string('fuel_type');
            $table->integer('price')->default(0)->unsigned();
            $table->timestamps();
        });

        Schema::table('cars', function (Blueprint $table) {
            $table->index('vin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
};
