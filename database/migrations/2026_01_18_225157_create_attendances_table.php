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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendances_setting_id')
                ->constrained('attendances_setting')
                ->cascadeOnDelete();
            $table->foreignId('participant_id')
                ->constrained('participants')
                ->cascadeOnDelete();
            $table->enum('method', ['faceRec', 'manual']);
            $table->dateTime('attended_at');
            $table->timestamps();

            $table->unique(
                ['attendances_setting_id', 'participant_id'],
                'attendances_unique_setting_participant'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
