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
        Schema::create('knowledge_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knowledge_test_id')->constrained()->onDelete('cascade');
            $table->text('question');
            $table->json('choices'); // A, B, C
            $table->string('bonne_reponse');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('knowledge_questions');
    }
};
