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
        Schema::create('rekenings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user');
            $table->string('nama_bank', 200)->nullable();
            $table->string('no_rekening', 200)->nullable();
            $table->string('nama_pemilik', 200)->nullable();
            $table->string('qrcode_bank', 250)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekenings');
    }
};
