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
        Schema::create('week_numbers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        DB::table('week_numbers')->insert([
            [
                'id' => 1
            ],
            [
                'id' => 2
            ],
            [
                'id' => 3
            ],
            [
                'id' => 4
            ],
            [
                'id' => 5
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('week_numbers');
    }
};
