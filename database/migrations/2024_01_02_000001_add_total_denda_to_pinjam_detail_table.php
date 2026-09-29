<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pinjam_detail', function (Blueprint $table) {
            $table->decimal('total_denda', 10, 2)->default(0)->after('lama_pinjam');
        });
    }

    public function down(): void
    {
        Schema::table('pinjam_detail', function (Blueprint $table) {
            $table->dropColumn('total_denda');
        });
    }
};
