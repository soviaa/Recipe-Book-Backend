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
            $table->integer('prep_time');
            $table->integer('cook_time');
            $table->integer('servings');
            $table->string('difficulty');
            $table->string('recipe_type');
            $table->string('image');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('category_id')->constrained();
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
