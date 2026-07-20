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
        Schema::create('service_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_id')->constrained('service_offers')->cascadeOnDelete();
            $table->foreignId('request_id')->constrained('service_requests')->cascadeOnDelete();
            $table->foreignId('helper_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('requester_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('proposed_by')->constrained('users')->cascadeOnDelete();
            $table->text('message')->nullable();
            $table->enum('statut', [
                'pending',
                'accepted',
                'refused',
                'completed',
                'disputed'
            ])->default('pending');
            $table->dateTime('scheduled_at')->nullable();
            $table->string('session_link')->nullable();
            $table->string('platform')->nullable();
            $table->decimal('estimated_duration', 4, 2)->nullable();
            $table->decimal('helper_declared_duration', 4, 2)->nullable();
            $table->decimal('requester_declared_duration', 4, 2)->nullable();
            $table->decimal('actual_duration', 4, 2)->nullable();
            $table->timestamp('helper_confirmed_at')->nullable();
            $table->timestamp('requester_confirmed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_matches');
    }
};
