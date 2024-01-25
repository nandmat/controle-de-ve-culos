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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id');
            $table->string('model');
            $table->string('brand');
            $table->string('license_plate')->unique();
            $table->string('model_date')->nullable();
            $table->string('fabrication_date')->nullable();
            $table->timestamps();

            $table->foreign('owner_id')
                ->references('id')
                ->on('owners');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};