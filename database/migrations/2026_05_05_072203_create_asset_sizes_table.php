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
        Schema::create('asset_sizes', function (Blueprint $table) {
            $table->id();
            $table->integer('asset_id')->nullable(); 
            $table->integer('size_tema_id')->nullable(); 
            $table->integer('breack_poin_id')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_sizes');
    }
};
