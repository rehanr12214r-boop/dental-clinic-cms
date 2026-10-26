<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Public-site content for treatments: URL slug, marketing copy and the
     * "what's included" / "before your visit" sections of the detail page.
     */
    public function up(): void
    {
        Schema::table('treatments', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('name');
            $table->text('description')->nullable()->after('cost');
            $table->text('whats_included')->nullable()->after('description');
            $table->text('pre_appointment_instructions')->nullable()->after('whats_included');
            $table->boolean('is_featured')->default(false)->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('treatments', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn([
                'slug',
                'description',
                'whats_included',
                'pre_appointment_instructions',
                'is_featured',
            ]);
        });
    }
};
