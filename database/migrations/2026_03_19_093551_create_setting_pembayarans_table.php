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
        Schema::create('setting_pembayarans', function (Blueprint $table) {
            $table->increments('id_setting');
            $table->enum('metode_bayar', ['manual','midtrans','tripay']);
            $table->string('bank_manual', 100)->nullable();
            $table->string('norek_manual', 100)->nullable();
            $table->string('nama_manual', 100)->nullable();
            $table->string('url_midtrans', 200)->nullable();
            $table->string('serverkey_midtrans', 200)->nullable();
            $table->string('clientkey_midtrans', 200)->nullable();
            $table->string('midtrans_production', 10)->nullable()->default('false');
            $table->string('url_tripay', 100)->nullable();
            $table->string('apikey_tripay', 100)->nullable();
            $table->string('privatekey_tripay', 100)->nullable();
            $table->string('merchantcode_tripay', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_pembayarans');
    }
};
