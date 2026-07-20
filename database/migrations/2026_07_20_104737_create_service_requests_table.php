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
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constained()->cascadeOnDelete();
            $table->foreignId('skill_id')->constrained()->cascadeOnDelete();
            $table->string('titre');
            $table->decimal('duree_estimee', 4, 2);
            $table->enum('urgence', ['low', 'normal', 'high'])->default('normal');
            $table->enum('statut', ['open', 'matched', 'closed'])->default('open');
            $table->enum('ai_status', ['pending', 'done', 'skipped'])->default('skipped');
            $table->json('ai_suggestion')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};
