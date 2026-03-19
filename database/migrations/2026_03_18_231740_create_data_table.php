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
        Schema::create('data', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user');
            $table->string('foto_pria', 50)->default('0');
            $table->string('foto_wanita', 50)->default('0');
            $table->longText('maps')->nullable();
            $table->string('video', 100);
            $table->string('kunci', 100);
            $table->text('salam_pembuka');
            $table->string('token_wa', 255)->nullable();
            $table->text('salam_wa_atas');
            $table->text('salam_wa_bawah');
            $table->timestamp('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data');
    }
};
