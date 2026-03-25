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
        Schema::create('themes_videos', function (Blueprint $table) {
            $table->increments('id_theme');
            $table->string('nama_tema', 100);
            $table->integer('harga');
            $table->string('preview', 200);
            $table->string('url_video', 250);
            $table->integer('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('themes_videos');
    }
};
