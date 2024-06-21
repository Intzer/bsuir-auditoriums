<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeekDay extends Model
{
    protected $fillable = [
        'id',
        'name',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'name' => 'string',
        ];
    }
}
