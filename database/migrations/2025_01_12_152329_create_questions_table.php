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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('identification');
            $table->text('question');
            $table->text('memory');
            $table->foreignId('tatami_id')->constrained('tatamis')->onDelete('cascade'); // Chave estrangeira para tatamis (não nulo)
            $table->foreignId('division_id')->constrained('divisions')->onDelete('cascade'); // Chave estrangeira para divisões (não nulo)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
