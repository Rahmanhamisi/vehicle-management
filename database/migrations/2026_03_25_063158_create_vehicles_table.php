<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
            Schema::create('vehicles', function (Blueprint $table) {
                $table->id();
                $table->string('plate_number')->unique();
                $table->string('model');
                $table->unsignedBigInteger('driver_id')->nullable();
                $table->timestamps();

                $table->foreign('driver_id')
                    ->references('id')
                    ->on('drivers')
                    ->onDelete('set null');
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
