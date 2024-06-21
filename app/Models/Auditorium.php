<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Building;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function isOccupied(): bool
    {
        $building = $this->building;

        $dayOfWeek = Carbon::now()->dayOfWeek + 1;
        $weekOfMonth = Carbon::now()->weekOfMonth;
        $currentTime = Carbon::now()->format('H:i');

        $lessons = Lesson::query()
            ->where('auditorium', $this->name.'='.$building->name)
            ->where('week_day', $dayOfWeek)
            ->whereHas('weeksNumbers', function ($query) use ($weekOfMonth) {
                $query->where('week_number_id', $weekOfMonth);
            })
            ->get();

        foreach ($lessons as $lesson)
        {
            $start = Carbon::createFromFormat('H:i', $lesson->start);
            $end = Carbon::createFromFormat('H:i', $lesson->start);
            if ($currentTime->gt($start) && $currentTime->lt($end)) {
                return true;
            }
        }

        return false;
    }
}
