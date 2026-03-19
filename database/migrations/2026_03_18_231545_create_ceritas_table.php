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
        Schema::create('cerita', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user');
            $table->string('tanggal_cerita', 50);
            $table->text('judul_cerita');
            $table->text('isi_cerita');
            $table->timestamp('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cerita');
    }
};
