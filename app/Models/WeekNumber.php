<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Lesson;

class WeekNumber extends Model
{
    protected $fillable = [
        'id'
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
        ];
    }

    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class);
    }
}
