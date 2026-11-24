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
        Schema::create('subjenispekerjaans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_jenis_pekerjaan')->unsigned();
            $table->foreign('id_jenis_pekerjaan')->references('id')->on('jenispekerjaans')->onDelete('cascade');
            $table->string('subjenis_pekerjaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjenispekerjaans');
    }
};
