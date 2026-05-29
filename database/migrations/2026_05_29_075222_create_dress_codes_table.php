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
        Schema::create('dress_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->string('title')->default('Dress Code');
            $table->text('description')->nullable();

            $table->string('background_color')->nullable();
            $table->string('text_color')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });

        Schema::create('dress_code_palettes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('dress_code_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('color_hex', 10);
            $table->string('color_name')->nullable();

            $table->integer('sort_order')->default(0);

            $table->timestamps();
        });

        Schema::create('dress_code_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('dress_code_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title');

            $table->text('description')->nullable();

            $table->string('image')->nullable();

            $table->string('type')->nullable();

            $table->integer('sort_order')->default(0);

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.sfsdfsdf
     */
    public function down(): void
    {
        Schema::dropIfExists('dress_code_items');
        Schema::dropIfExists('dress_code_palettes');
        Schema::dropIfExists('dress_codes');
    }
};