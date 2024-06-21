<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Group;
use App\Models\WeekNumber;
use App\Models\Auditorium;

class Lesson extends Model
{
    protected $fillable = [
        'id',
        'name',
        'group_id',
        'week_day',
        'auditorium',
        'start_time',
        'end_time',
        'note',
        'num_subgroup',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'name' => 'string',
            'group_id' => 'integer',
            'week_day' => 'integer',
            'auditorium' => 'string',
            'start_time' => 'string',
            'end_time' => 'string',
            'num_subgroup',
        ];
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
    
    public function WeeksNumbers(): BelongsToMany
    {
        return $this->belongsToMany(WeekNumber::class);
    }

    public function auditoriums(): BelongsToMany
    {
        return $this->belongsToMany(Auditorium::class);
    }
}
