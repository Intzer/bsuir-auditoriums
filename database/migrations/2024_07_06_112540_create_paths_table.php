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
        Schema::create('paths', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->text('map');
            $table->text('rooms');
            $table->foreignId('building_id');
        });

        DB::table('paths')->insert([
            [
                'map' => json_encode([
                    0 => [
                        [' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '],
                        [' ', ' ', ' ', ' ', ' ', ' ', 'r', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '],
                        [' ', ' ', ' ', ' ', ' ', ' ', 'c', 's', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '],
                        [' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '],
                    ],
                    1 => [
                        [' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '],
                        [' ', ' ', ' ', ' ', ' ', ' ', 'r', ' ', ' ', ' ', ' ', ' ', ' '],
                        [' ', ' ', ' ', ' ', 'c', 'c', 'c', 's', ' ', ' ', ' ', ' ', ' '],
                        [' ', ' ', 'r', ' ', 'c', 'c', 'c', ' ', ' ', 'r', 'r', 'r', ' '],
                        [' ', 'r', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', ' '],
                        [' ', ' ', 'r', 'r', ' ', 'c', 'c', 'c', 'c', 'c', 'c', 'c', ' '],
                        [' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', 'r', 'r', 'r', ' '],
                        [' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '],
                    ],
                    2 => [
                        [' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '],
                        [' ', ' ', ' ', ' ', ' ', ' ', 'r', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '],
                        [' ', 'r', ' ', 'r', ' ', ' ', 'c', 's', ' ', ' ', 'r', 'r', ' ', 'r', 'r', 'r', 'r', ' '],
                        [' ', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', ' '],
                        [' ', 'r', 'r', 'r', 'r', 'r', ' ', ' ', 'r', ' ', 'r', 'r', ' ', ' ', 'r', ' ', 'r', ' '],
                        [' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '],
                    ],
                    3 => [
                        [' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '],
                        [' ', 'r', 'r', 'r', 'r', ' ', 'c', 'с', 's', ' ', ' ', ' ', 'r', 'r', 'r', 'r', 'c', 'r', 'r', ' '],
                        [' ', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', ' '],
                        [' ', 'r', 'r', 'r', 'r', 'r', 'r', 'r', 'r', ' ', 'r', ' ', 'r', 'r', 'r', 'r', 'r', 'r', 'r', ' '],
                        [' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '],
                    ],
                    4 => [
                        [' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '],
                        [' ', 'r', 'r', 'r', ' ', ' ', 'c', 'с', 's', ' ', ' ', ' ', 'r', 'r', 'r', 'r', 'r', 'c', 'r', 'r', ' '],
                        [' ', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', ' '],
                        [' ', 'r', 'r', 'r', 'r', 'r', 'r', 'r', 'r', 'r', 'r', 'r', 'r', 'r', 'r', 'r', 'r', 'r', 'r', 'r', ' '],
                        [' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '],
                    ],
                    5 => [
                        [' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '],
                        [' ', 'r', 'r', 'r', ' ', ' ', 'c', 'с', 's', ' ', ' ', ' ', 'r', 'r', 'r', 'r', 'c', 'r', 'r', 'r', ' '],
                        [' ', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', ' '],
                        [' ', 'r', 'r', 'r', ' ', ' ', 'r', 'r', 'r', 'r', ' ', 'r', 'r', 'r', 'r', ' ', ' ', ' ', 'r', 'r', ' '],
                        [' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '],
                    ],
                ]),
                'rooms' => json_encode([
                    // Zero floor
                    [
                        'name' => '04',
                        'floor' => 0,
                        'x' => 6,
                        'y' => 1,
                    ],
                    // First floor
                    [
                        'name' => '112',
                        'floor' => 1,
                        'x' => 2,
                        'y' => 3,
                    ],
                    [
                        'name' => '111',
                        'floor' => 1,
                        'x' => 1,
                        'y' => 4,
                    ],
                    [
                        'name' => '109',
                        'floor' => 1,
                        'x' => 2,
                        'y' => 5,
                    ],
                    [
                        'name' => '109в',
                        'floor' => 1,
                        'x' => 3,
                        'y' => 5,
                    ],
                    [
                        'name' => '102',
                        'floor' => 1,
                        'x' => 6,
                        'y' => 1,
                    ],
                    [
                        'name' => '101',
                        'floor' => 1,
                        'x' => 9,
                        'y' => 3,
                    ],
                    [
                        'name' => '103',
                        'floor' => 1,
                        'x' => 10,
                        'y' => 3,
                    ],
                    [
                        'name' => '107',
                        'floor' => 1,
                        'x' => 11,
                        'y' => 3,
                    ],
                    [
                        'name' => '104',
                        'floor' => 1,
                        'x' => 9,
                        'y' => 6,
                    ],
                    [
                        'name' => '106',
                        'floor' => 1,
                        'x' => 10,
                        'y' => 6,
                    ],
                    [
                        'name' => '108',
                        'floor' => 1,
                        'x' => 11,
                        'y' => 6,
                    ],
                    // Second floor
                    [
                        'name' => '201',
                        'floor' => 2,
                        'x' => 1,
                        'y' => 2,
                    ],
                    [
                        'name' => '203',
                        'floor' => 2,
                        'x' => 3,
                        'y' => 2,
                    ],
                    [
                        'name' => '202',
                        'floor' => 2,
                        'x' => 1,
                        'y' => 4,
                    ],
                    [
                        'name' => '205',
                        'floor' => 2,
                        'x' => 2,
                        'y' => 4,
                    ],
                    [
                        'name' => '206',
                        'floor' => 2,
                        'x' => 3,
                        'y' => 4,
                    ],
                    [
                        'name' => '207',
                        'floor' => 2,
                        'x' => 4,
                        'y' => 4,
                    ],
                    [
                        'name' => '208',
                        'floor' => 2,
                        'x' => 5,
                        'y' => 4,
                    ],
                    [
                        'name' => '209',
                        'floor' => 2,
                        'x' => 6,
                        'y' => 1,
                    ],
                    [
                        'name' => '210',
                        'floor' => 2,
                        'x' => 8,
                        'y' => 4,
                    ],
                    [
                        'name' => '211',
                        'floor' => 2,
                        'x' => 10,
                        'y' => 4,
                    ],
                    [
                        'name' => '212',
                        'floor' => 2,
                        'x' => 11,
                        'y' => 4,
                    ],
                    [
                        'name' => '214',
                        'floor' => 2,
                        'x' => 14,
                        'y' => 4,
                    ],
                    [
                        'name' => '216',
                        'floor' => 2,
                        'x' => 16,
                        'y' => 4,
                    ],
                    [
                        'name' => '213б',
                        'floor' => 2,
                        'x' => 10,
                        'y' => 2,
                    ],
                    [
                        'name' => '213а',
                        'floor' => 2,
                        'x' => 11,
                        'y' => 2,
                    ],
                    [
                        'name' => '215',
                        'floor' => 2,
                        'x' => 13,
                        'y' => 2,
                    ],
                    [
                        'name' => '215а',
                        'floor' => 2,
                        'x' => 14,
                        'y' => 2,
                    ],
                    [
                        'name' => '216',
                        'floor' => 2,
                        'x' => 15,
                        'y' => 2,
                    ],
                    [
                        'name' => '217',
                        'floor' => 2,
                        'x' => 16,
                        'y' => 2,
                    ],
                    // Third floor
                    [
                        'name' => '301',
                        'floor' => 3,
                        'x' => 1,
                        'y' => 1,
                    ],
                    [
                        'name' => '305а',
                        'floor' => 3,
                        'x' => 2,
                        'y' => 1,
                    ],
                    [
                        'name' => '305',
                        'floor' => 3,
                        'x' => 3,
                        'y' => 1,
                    ],
                    [
                        'name' => '306',
                        'floor' => 3,
                        'x' => 4,
                        'y' => 1,
                    ],
                    [
                        'name' => '302',
                        'floor' => 3,
                        'x' => 1,
                        'y' => 3,
                    ],
                    [
                        'name' => '302а',
                        'floor' => 3,
                        'x' => 2,
                        'y' => 3,
                    ],
                    [
                        'name' => '304',
                        'floor' => 3,
                        'x' => 3,
                        'y' => 3,
                    ],
                    [
                        'name' => '307',
                        'floor' => 3,
                        'x' => 4,
                        'y' => 3,
                    ],
                    [
                        'name' => '307а',
                        'floor' => 3,
                        'x' => 5,
                        'y' => 3,
                    ],
                    [
                        'name' => '323',
                        'floor' => 3,
                        'x' => 6,
                        'y' => 3,
                    ],
                    [
                        'name' => '324б',
                        'floor' => 3,
                        'x' => 7,
                        'y' => 3,
                    ],
                    [
                        'name' => '324а',
                        'floor' => 3,
                        'x' => 8,
                        'y' => 3,
                    ],
                    [
                        'name' => '310',
                        'floor' => 3,
                        'x' => 10,
                        'y' => 3,
                    ],
                    [
                        'name' => '311',
                        'floor' => 3,
                        'x' => 12,
                        'y' => 3,
                    ],
                    [
                        'name' => '312',
                        'floor' => 3,
                        'x' => 13,
                        'y' => 3,
                    ],
                    [
                        'name' => '314',
                        'floor' => 3,
                        'x' => 14,
                        'y' => 3,
                    ],
                    [
                        'name' => '316',
                        'floor' => 3,
                        'x' => 15,
                        'y' => 3,
                    ],
                    [
                        'name' => '318',
                        'floor' => 3,
                        'x' => 16,
                        'y' => 3,
                    ],
                    [
                        'name' => '320',
                        'floor' => 3,
                        'x' => 17,
                        'y' => 3,
                    ],
                    [
                        'name' => '322',
                        'floor' => 3,
                        'x' => 18,
                        'y' => 3,
                    ],
                    [
                        'name' => '310',
                        'floor' => 3,
                        'x' => 12,
                        'y' => 1,
                    ],
                    [
                        'name' => '313',
                        'floor' => 3,
                        'x' => 13,
                        'y' => 1,
                    ],
                    [
                        'name' => '315',
                        'floor' => 3,
                        'x' => 14,
                        'y' => 1,
                    ],
                    [
                        'name' => '317',
                        'floor' => 3,
                        'x' => 15,
                        'y' => 1,
                    ],
                    [
                        'name' => '319',
                        'floor' => 3,
                        'x' => 17,
                        'y' => 1,
                    ],
                    [
                        'name' => '321',
                        'floor' => 3,
                        'x' => 18,
                        'y' => 1,
                    ],
                    // Fouth floor
                    [
                        'name' => '401',
                        'floor' => 4,
                        'x' => 1,
                        'y' => 1,
                    ],
                    [
                        'name' => '403',
                        'floor' => 4,
                        'x' => 2,
                        'y' => 1,
                    ],
                    [
                        'name' => '405',
                        'floor' => 4,
                        'x' => 3,
                        'y' => 1,
                    ],
                    [
                        'name' => '400',
                        'floor' => 4,
                        'x' => 1,
                        'y' => 3,
                    ],
                    [
                        'name' => '402',
                        'floor' => 4,
                        'x' => 2,
                        'y' => 3,
                    ],
                    [
                        'name' => '404',
                        'floor' => 4,
                        'x' => 3,
                        'y' => 3,
                    ],
                    [
                        'name' => '406',
                        'floor' => 4,
                        'x' => 4,
                        'y' => 3,
                    ],
                    [
                        'name' => '408',
                        'floor' => 4,
                        'x' => 5,
                        'y' => 3,
                    ],
                    [
                        'name' => '426',
                        'floor' => 4,
                        'x' => 6,
                        'y' => 3,
                    ],
                    [
                        'name' => '427',
                        'floor' => 4,
                        'x' => 7,
                        'y' => 3,
                    ],
                    [
                        'name' => '428',
                        'floor' => 4,
                        'x' => 8,
                        'y' => 3,
                    ],
                    [
                        'name' => '409-1',
                        'floor' => 4,
                        'x' => 9,
                        'y' => 3,
                    ],
                    [
                        'name' => '409',
                        'floor' => 4,
                        'x' => 10,
                        'y' => 3,
                    ],
                    [
                        'name' => '410-2',
                        'floor' => 4,
                        'x' => 11,
                        'y' => 3,
                    ],
                    [
                        'name' => '412',
                        'floor' => 4,
                        'x' => 12,
                        'y' => 3,
                    ],
                    [
                        'name' => '413',
                        'floor' => 4,
                        'x' => 13,
                        'y' => 3,
                    ],
                    [
                        'name' => '415',
                        'floor' => 4,
                        'x' => 14,
                        'y' => 3,
                    ],
                    [
                        'name' => '417',
                        'floor' => 4,
                        'x' => 15,
                        'y' => 3,
                    ],
                    [
                        'name' => '419',
                        'floor' => 4,
                        'x' => 16,
                        'y' => 3,
                    ],
                    [
                        'name' => '420',
                        'floor' => 4,
                        'x' => 17,
                        'y' => 3,
                    ],
                    [
                        'name' => '422',
                        'floor' => 4,
                        'x' => 18,
                        'y' => 3,
                    ],
                    [
                        'name' => '424',
                        'floor' => 4,
                        'x' => 19,
                        'y' => 3,
                    ],
                    [
                        'name' => '410-1',
                        'floor' => 4,
                        'x' => 12,
                        'y' => 1,
                    ],
                    [
                        'name' => '411',
                        'floor' => 4,
                        'x' => 13,
                        'y' => 1,
                    ],
                    [
                        'name' => '414',
                        'floor' => 4,
                        'x' => 14,
                        'y' => 1,
                    ],
                    [
                        'name' => '416',
                        'floor' => 4,
                        'x' => 15,
                        'y' => 1,
                    ],
                    [
                        'name' => '418',
                        'floor' => 4,
                        'x' => 16,
                        'y' => 1,
                    ],
                    [
                        'name' => '421',
                        'floor' => 4,
                        'x' => 18,
                        'y' => 1,
                    ],
                    [
                        'name' => '423',
                        'floor' => 4,
                        'x' => 19,
                        'y' => 1,
                    ],
                    // Fifth floor
                    [
                        'name' => '501',
                        'floor' => 5,
                        'x' => 1,
                        'y' => 1,
                    ],
                    [
                        'name' => '504',
                        'floor' => 5,
                        'x' => 2,
                        'y' => 1,
                    ],
                    [
                        'name' => '505',
                        'floor' => 5,
                        'x' => 3,
                        'y' => 1,
                    ],
                    [
                        'name' => '502',
                        'floor' => 5,
                        'x' => 1,
                        'y' => 3,
                    ],
                    [
                        'name' => '503',
                        'floor' => 5,
                        'x' => 2,
                        'y' => 3,
                    ],
                    [
                        'name' => '503а',
                        'floor' => 5,
                        'x' => 3,
                        'y' => 3,
                    ],
                    [
                        'name' => '514',
                        'floor' => 5,
                        'x' => 6,
                        'y' => 3,
                    ],
                    [
                        'name' => '515',
                        'floor' => 5,
                        'x' => 7,
                        'y' => 3,
                    ],
                    [
                        'name' => '516',
                        'floor' => 5,
                        'x' => 8,
                        'y' => 3,
                    ],
                    [
                        'name' => '506',
                        'floor' => 5,
                        'x' => 9,
                        'y' => 3,
                    ],
                    [
                        'name' => '507',
                        'floor' => 5,
                        'x' => 11,
                        'y' => 3,
                    ],
                    [
                        'name' => '508',
                        'floor' => 5,
                        'x' => 12,
                        'y' => 3,
                    ],
                    [
                        'name' => '510а',
                        'floor' => 5,
                        'x' => 13,
                        'y' => 3,
                    ],
                    [
                        'name' => '510',
                        'floor' => 5,
                        'x' => 14,
                        'y' => 3,
                    ],
                    [
                        'name' => '512',
                        'floor' => 5,
                        'x' => 18,
                        'y' => 3,
                    ],
                    [
                        'name' => '512а',
                        'floor' => 5,
                        'x' => 19,
                        'y' => 3,
                    ],
                    [
                        'name' => '509',
                        'floor' => 5,
                        'x' => 12,
                        'y' => 1,
                    ],
                    [
                        'name' => '509а',
                        'floor' => 5,
                        'x' => 13,
                        'y' => 1,
                    ],
                    [
                        'name' => '511а',
                        'floor' => 5,
                        'x' => 14,
                        'y' => 1,
                    ],
                    [
                        'name' => '511',
                        'floor' => 5,
                        'x' => 15,
                        'y' => 1,
                    ],
                    [
                        'name' => '513',
                        'floor' => 5,
                        'x' => 17,
                        'y' => 1,
                    ],
                    [
                        'name' => '513б',
                        'floor' => 5,
                        'x' => 18,
                        'y' => 1,
                    ],
                    [
                        'name' => '513а',
                        'floor' => 5,
                        'x' => 19,
                        'y' => 1,
                    ],
                ]),
                'building_id' => 4,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paths');
    }
};
