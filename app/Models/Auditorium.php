<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Building;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Auditorium extends Model
{
    protected $fillable = [
        'id',
        'name',
        'building_id',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'name' => 'string',
            'building_id' => 'integer',
        ];
    }

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }
}
