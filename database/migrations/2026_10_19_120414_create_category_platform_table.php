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
        Schema::create('category_platform', function (Blueprint $table) {
            $table->id();
            $table->foreignId('platform_id')->constrained('platforms')->onDelete('cascade');
            $table->foreignId('platform_category_id')->constrained('platform_categories')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['platform_id', 'platform_category_id']);
        });

        // Migrate existing relation from platforms table to category_platform
        $existingPlatforms = \DB::table('platforms')->whereNotNull('platform_category_id')->get();
        foreach ($existingPlatforms as $platform) {
            \DB::table('category_platform')->insertOrIgnore([
                'platform_id' => $platform->id,
                'platform_category_id' => $platform->platform_category_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Make old platform_category_id nullable on platforms
        Schema::table('platforms', function (Blueprint $table) {
            $table->foreignId('platform_category_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_platform');
    }
};
