<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('week_days', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        DB::table('week_days')->insert([
            [
                'name' => 'Понедельник'
            ],
            [
                'name' => 'Вторник'
            ],
            [
                'name' => 'Среда'
            ],
            [
                'name' => 'Четверг'
            ],
            [
                'name' => 'Пятница'
            ],
            [
                'name' => 'Суббота'
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('week_days');
    }
};
