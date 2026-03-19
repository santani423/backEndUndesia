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
        Schema::create('acaras', function (Blueprint $table) {
            $table->increments('id_acara');
            $table->string('nama_acara', 50);
            $table->string('tgl_acara', 20)->nullable();
            $table->string('waktu_mulai', 10);
            $table->string('waktu_akhir', 10);
            $table->string('tempat_acara', 100);
            $table->text('alamat_acara');
            $table->text('maps')->nullable();
            $table->enum('set_countdown', ['Y', 'N'])->nullable()->default('N');
            $table->integer('id_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acaras');
    }
};
