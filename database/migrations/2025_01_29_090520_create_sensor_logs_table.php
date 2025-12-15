<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sensor_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gateway_id')->constrained();
            $table->foreignId('sensor_id')->constrained();
            $table->float('voltage_ab')->nullable();
            $table->float('voltage_bc')->nullable();
            $table->float('voltage_ca')->nullable();
            $table->float('current_a')->nullable();
            $table->float('current_b')->nullable();
            $table->float('current_c')->nullable();
            $table->float('real_power')->nullable();
            $table->float('apparent_power')->nullable();
            $table->float('energy')->nullable();
            $table->float('temperature')->nullable();
            $table->float('humidity')->nullable();
            $table->float('volume')->nullable();
            $table->float('flow')->nullable();
            $table->float('pressure')->nullable();
            $table->float('co2')->nullable();
            $table->float('pm25_pm10')->nullable();
            $table->float('o2')->nullable();
            $table->float('nox')->nullable();
            $table->float('co')->nullable();
            $table->float('s02')->nullable();
            $table->dateTime('datetime_created');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_logs');
    }
};
