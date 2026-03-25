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
        Schema::create('rules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user');
            $table->integer('sampul');
            $table->integer('mempelai');
            $table->integer('acara');
            $table->integer('komen');
            $table->integer('gallery');
            $table->integer('cerita');
            $table->integer('lokasi');
            $table->integer('prokes');
            $table->integer('qrcode');
            $table->integer('hadiah');
            $table->integer('quote');
            $table->timestamp('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rules');
    }
};
