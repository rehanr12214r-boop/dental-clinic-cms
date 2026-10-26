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
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('category')->default('General');
            $table->string('image')->default('blog-1.jpg');
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();   // Markdown / HTML body
            $table->json('sections')->nullable();       // structured {heading, body[]} array
            $table->string('quote')->nullable();
            $table->string('quote_author')->nullable();
            $table->string('author')->default('The Clinic Team');
            $table->string('author_role')->default('Story Teller');
            $table->string('author_image')->default('team-james.jpg');
            $table->string('read_time')->default('4 min read');
            $table->date('published_at')->nullable();
            $table->enum('status', ['draft', 'published'])->default('published');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
