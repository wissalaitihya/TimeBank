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
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('score_reputation', 3, 2)
                ->default(0)
                ->after('statut_compte');

            $table->json('ai_generated_bio')
                ->nullable()
                ->after('score_reputation');
        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
             $table->dropColumn([
                'score_reputation',
                'ai_generated_bio',
            ]);
        });
    }
};
