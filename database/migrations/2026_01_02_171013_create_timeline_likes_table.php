<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('timeline_likes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('timeline_post_id')
                ->constrained('timeline_posts')
                ->onDelete('cascade');

            $table->timestamps();

            
            $table->unique(['user_id', 'timeline_post_id']);
        });
    }


   
    public function down(): void
    {
        Schema::dropIfExists('timeline_likes');
    }
};
