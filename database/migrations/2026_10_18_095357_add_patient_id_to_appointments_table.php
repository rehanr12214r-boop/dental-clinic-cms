<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Link appointments to a patient account when the booking was made while
     * signed in (guest bookings stay unlinked and can be claimed later by
     * registering with the same phone number).
     */
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->foreignId('patient_id')
                ->nullable()
                ->after('id')
                ->constrained('patients')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropConstrainedForeignId('patient_id');
        });
    }
};
