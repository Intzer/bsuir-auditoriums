<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Auditorium;


class Building extends Model
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

    public function auditoriums(): HasMany
    {
        return $this->hasMany(Auditorium::class);
    }
}
