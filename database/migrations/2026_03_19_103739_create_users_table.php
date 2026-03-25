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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hp', 15);
            $table->string('email', 100);
            $table->string('username', 100);
            $table->string('password', 100);
            $table->string('id_unik', 500);
            $table->timestamp('created_at')->useCurrent();
            $table->text('token')->nullable();
            $table->timestamp('created_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
