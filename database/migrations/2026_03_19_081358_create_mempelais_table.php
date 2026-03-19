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
        Schema::create('mempelais', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user');
            $table->string('nama_pria', 50);
            $table->string('nama_panggilan_pria', 50);
            $table->string('nama_ibu_pria', 50);
            $table->string('nama_ayah_pria', 50);
            $table->string('nama_wanita', 50);
            $table->string('nama_panggilan_wanita', 50);
            $table->string('nama_ibu_wanita', 50);
            $table->string('nama_ayah_wanita', 50);
            $table->enum('posisi_mempelai', ['0','1']);
            $table->timestamp('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mempelais');
    }
};
