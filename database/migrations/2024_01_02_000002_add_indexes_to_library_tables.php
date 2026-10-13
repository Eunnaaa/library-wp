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
        Schema::table('booking', function (Blueprint $table) {
            $table->index('batas_ambil');
        });

        Schema::table('pinjam', function (Blueprint $table) {
            $table->index('tgl_pinjam');
        });

        Schema::table('pinjam_detail', function (Blueprint $table) {
            $table->index('status');
            $table->index('tgl_kembali');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pinjam_detail', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['tgl_kembali']);
        });

        Schema::table('pinjam', function (Blueprint $table) {
            $table->dropIndex(['tgl_pinjam']);
        });

        Schema::table('booking', function (Blueprint $table) {
            $table->dropIndex(['batas_ambil']);
        });
    }
};
