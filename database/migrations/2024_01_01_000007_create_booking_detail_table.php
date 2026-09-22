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
        Schema::create('booking_detail', function (Blueprint $table) {
            $table->id();
            $table->string('id_booking');
            $table->foreignId('id_buku')->constrained('buku')->onDelete('cascade');
            $table->timestamps();

            $table->foreign('id_booking')->references('id_booking')->on('booking')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_detail');
    }
};
