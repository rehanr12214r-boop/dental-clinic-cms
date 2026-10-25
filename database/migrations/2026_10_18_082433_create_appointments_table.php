<?php

use App\Enums\AppointmentStatus;
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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('patient_name');
            $table->string('patient_phone', 32);
            $table->unsignedSmallInteger('patient_age');
            $table->foreignId('treatment_id')
                ->constrained()
                ->restrictOnDelete()
                ->cascadeOnUpdate();
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->string('status', 32)->default(AppointmentStatus::Pending->value)->index();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Speeds up the per-day availability lookups.
            $table->index(['appointment_date', 'appointment_time']);

            // NOTE: double-booking is prevented by the slot availability service
            // inside a serialized transaction, which also guards overlapping
            // longer treatments and keeps a cancelled appointment's slot
            // bookable again. A plain unique(date, time) index would make a
            // cancelled appointment's slot unusable forever.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
