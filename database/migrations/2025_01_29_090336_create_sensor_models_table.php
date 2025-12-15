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
        Schema::create('sensor_models', function (Blueprint $table) {
            $table->id();
            $table->string('sensor_model')->unique();
            $table->string('sensor_brand');
            $table->foreignId('sensor_type_id')->constrained();
            $table->string('sensor_reg_address');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_models');
    }
};
