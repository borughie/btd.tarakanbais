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
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->string('instansi');
            $table->text('tujuan');
            $table->unsignedInteger('jumlah_personil')->default(1);
            $table->string('nama_pic')->nullable();
            $table->string('no_hp')->nullable();
            $table->boolean('synced_to_sheet')->default(false);
            $table->boolean('notified')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
