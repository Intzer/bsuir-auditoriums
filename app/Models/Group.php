<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Lesson;

class Group extends Model
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

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }
}
