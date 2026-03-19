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
        Schema::create('pakets', function (Blueprint $table) {
            $table->increments('id_paket');
            $table->string('nama_paket', 100);
            $table->string('harga_paket', 100);
            $table->integer('masa_aktif');
            $table->integer('buku_tamu');
            $table->integer('kirim_whatsapp');
            $table->integer('tema_bebas');
            $table->integer('kirim_hadiah');
            $table->integer('import_datatamu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pakets');
    }
};
