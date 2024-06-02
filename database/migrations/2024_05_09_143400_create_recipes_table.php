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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->json('prep_time')->nullable();
            $table->json('cook_time')->nullable();
            $table->integer('servings');
            $table->json('ingredients')->nullable();
            $table->string('difficulty')->nullable();
            $table->string('recipe_type')->nullable();
            $table->string('image')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('category_id')->nullable()->constrained();
            $table->boolean('is_private')->default(false);
            $table->boolean('is_approved')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
