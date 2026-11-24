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
        Schema::create('dayas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_tarif')->unsigned();
            $table->foreign('id_tarif')->references('id')->on('tarifs')->onDelete('cascade');
            $table->integer('daya');
            $table->decimal('rp_tarif', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dayas');
    }
};
