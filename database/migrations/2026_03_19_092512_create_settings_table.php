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
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->double('harga');
            $table->string('img', 100);
            $table->timestamp('created_at')->useCurrent()->useCurrentOnUpdate();
            $table->integer('trial');
            $table->integer('aktif');
            $table->string('host_email', 200)->nullable();
            $table->string('email', 200)->nullable();
            $table->string('pass_email', 255)->nullable();
            $table->string('no_wa', 15)->nullable();
            $table->text('pesan_wa')->nullable();
            $table->longText('salam_pembuka')->nullable();
            $table->enum('wa_gateway', ['nusagateway','starsender','onesender'])->default('nusagateway');
            $table->string('token_wa', 255)->nullable();
            $table->text('salam_wa_atas');
            $table->text('salam_wa_bawah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
