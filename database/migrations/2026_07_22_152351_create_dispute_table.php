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
        Schema::create('dispute', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_match_id')->constrained('service_matches')->cascadeOnDelete();
            $table->foreignId('opened_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('resolved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('reason');
            $table->text('description')->nullable();
            $table->enum('status', ['open', 'resolved', 'closed'])->default('open');
            $table->text('admin_decision')->nullable();
            $table->decimal('approved_duration', 4, 2)->nullable();
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dispute');
    }
};
