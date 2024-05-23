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
            $table->id();
            $table->boolean('2fa')->default('0');
            $table->boolean('private_account')->default('0');
            $table->boolean('recipe_recommendation')->default('0');
            $table->boolean('friends_activities')->default('0');
            $table->boolean('promotional_updates')->default('0');
            $table->boolean('system_notification')->default('0');
            $table->enum('cook_type', ['rookie', 'midbie', 'master'])->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
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
