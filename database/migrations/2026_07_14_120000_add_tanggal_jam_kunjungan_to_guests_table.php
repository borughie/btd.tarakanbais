<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->date('tanggal_kunjungan')->nullable()->after('no_hp');
            $table->time('jam_kunjungan')->nullable()->after('tanggal_kunjungan');
        });
    }

    public function down(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->dropColumn(['tanggal_kunjungan', 'jam_kunjungan']);
        });
    }
};
