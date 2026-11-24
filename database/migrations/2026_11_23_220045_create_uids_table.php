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
        Schema::create('uids', function (Blueprint $table) {
            $table->id();
            $table->string('kode_unit_induk', 150);
            $table->string('nama_unit_induk', 150);
            $table->integer('bpp_kit')->nullable();
            $table->integer('bpp_tt')->nullable();
            $table->integer('bpp_tr')->nullable();
            $table->integer('bpp_tr_plus_margin')->nullable();
            $table->decimal('susut', 15, 2)->nullable();
            $table->decimal('oem', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uids');
    }
};
