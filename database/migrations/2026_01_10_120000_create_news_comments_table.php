<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Reacties van gebruikers op nieuwsberichten (one-to-many).
     */
    public function up(): void
    {
        Schema::create('news_comments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('news_item_id')
                ->constrained('news_items')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->text('body');
            $table->timestamps();

            $table->index(['news_item_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_comments');
    }
};
