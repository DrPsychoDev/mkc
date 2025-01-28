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
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string('photo')->default('participants/photos/avatar.png');
            $table->string('name');
            $table->date('birthday')->nullable();
            $table->foreignId('school_id')->nullable();
            $table->foreignId('division_id')->nullable();
            $table->boolean('is_present')->default(false); // Para indicar se o participante está presente
            $table->text('absence_reason')->nullable(); // Para armazenar o motivo da ausência
            $table->boolean('has_dropped_out')->default(false); // Para indicar se o participante desistiu
            $table->text('dropout_reason')->nullable(); // Para armazenar o motivo da desistência
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
