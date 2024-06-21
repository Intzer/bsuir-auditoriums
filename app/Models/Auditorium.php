<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Building;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Carbon\Carbon;

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

    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class);
    }

    public function isOccupiedNow(): bool
    {
        $weekDay = Carbon::now()->dayOfWeek;
        $weekMonth = Carbon::now()->weekOfMonth;
        $now = Carbon::now();

        $lessons = $this->lessons()
            ->where('week_day_id', $weekDay)
            ->whereHas('weeksNumbers', function ($query) use ($weekMonth) {
                $query->where('week_number_id', $weekMonth);
            })
            ->get();
        
        foreach ($lessons as $lesson)
        {
            $startTime = Carbon::createFromFormat('H:i', $lesson->start_time);
            $endTime = Carbon::createFromFormat('H:i', $lesson->end_time);
            if ($now->between($startTime, $endTime)) {
                return true;
            }
        }

        return false;
    }
}
