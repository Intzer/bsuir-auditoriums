<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Group;
use App\Models\WeekNumber;
use App\Models\Auditorium;
use Carbon\Carbon;

class Lesson extends Model
{
    protected $fillable = [
        'id',
        'name',
        'group_id',
        'week_day_id',
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
            'week_day_id' => 'integer',
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
    
    public function weeksNumbers(): BelongsToMany
    {
        return $this->belongsToMany(WeekNumber::class);
    }

    public function auditoriums(): BelongsToMany
    {
        return $this->belongsToMany(Auditorium::class);
    }

    public function isPassingNow(): bool
    {
        $weekDay = Carbon::now()->dayOfWeek;
        $weekMonth = Carbon::now()->weekOfMonth;
        $now = Carbon::now();

        $startTime = Carbon::createFromFormat('H:i', $this->start_time);
        $endTime = Carbon::createFromFormat('H:i', $this->end_time);
        if (!$now->between($startTime, $endTime)) {
            return false;
        }

        if ($this->week_day_id != $weekDay) {
            return false;
        }

        $weeksNumbers = $this->weeksNumbers()
            ->where('week_numbers.id', $weekMonth)
            ->get();

        if ($weeksNumbers->isEmpty()) {
            return false;
        }

        return true;
    }
}
