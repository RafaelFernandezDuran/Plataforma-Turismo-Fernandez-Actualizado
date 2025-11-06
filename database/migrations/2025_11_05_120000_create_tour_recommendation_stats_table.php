<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_recommendation_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tour_category_id')->constrained('tour_categories')->cascadeOnDelete();
            $table->string('difficulty_level', 20)->nullable();
            $table->unsignedInteger('total_bookings')->default(0);
            $table->unsignedInteger('completed_bookings')->default(0);
            $table->unsignedInteger('cancelled_bookings')->default(0);
            $table->decimal('average_rating', 3, 2)->default(0);
            $table->timestamp('calculated_at')->useCurrent();
            $table->timestamps();

            $table->unique(['tour_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_recommendation_stats');
    }
};
