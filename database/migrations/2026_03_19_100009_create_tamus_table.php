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
        Schema::create('tamus', function (Blueprint $table) {
            $table->increments('id_tamu');
            $table->string('nama_tamu', 100);
            $table->string('nama_slug', 255);
            $table->string('alamat_tamu', 255);
            $table->string('alamat_slug', 255);
            $table->string('no_wa', 100);
            $table->string('qrcode', 255);
            $table->integer('id_user');
            $table->date('tgl_kirim');
            $table->string('status_kirim', 100)->default('belum dikirim');
            $table->string('status', 100)->nullable();
            $table->dateTime('waktu_hadir')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tamus');
    }
};
