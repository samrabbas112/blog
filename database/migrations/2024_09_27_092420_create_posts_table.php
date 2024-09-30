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
        Schema::create('posts', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique();
                $table->text('body');
                $table->text('excerpt')->nullable();
                $table->json('featured_image')->nullable();
                $table->foreignId('category_id')->constrained()->onDelete('cascade');
                $table->foreignId('admin_id')->constrained('admins')->onDelete('cascade');
                $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
                $table->boolean('is_trending')->default(false);
                $table->boolean('is_featured')->default(false);
                $table->boolean('is_top')->default(false);               
                $table->timestamp('published_at')->nullable();
                $table->string('meta_description')->nullable();
                $table->string('meta_keywords')->nullable();
                $table->unsignedBigInteger('view_count')->default(0);
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
