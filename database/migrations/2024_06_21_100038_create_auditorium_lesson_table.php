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
        Schema::create('auditorium_lesson', function (Blueprint $table) {
            $table->id();
            $table->foreignId('auditorium_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('lesson_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditorium_lesson');
    }
};
