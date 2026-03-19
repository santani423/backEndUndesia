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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user');
            $table->string('invoice', 50);
            $table->string('nama_lengkap', 200)->nullable();
            $table->string('bukti', 200)->nullable();
            $table->string('nama_bank', 100);
            $table->string('va_number', 200);
            $table->integer('status')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->integer('harga')->default(0);
            $table->string('payment_type', 200);
            $table->string('transaction_status', 100);
            $table->dateTime('transaction_time')->nullable();
            $table->dateTime('transaction_expired')->nullable();
            $table->string('biller_code', 100)->nullable();
            $table->text('instruction');
            $table->enum('status_order', ['0','1'])->default('1');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
