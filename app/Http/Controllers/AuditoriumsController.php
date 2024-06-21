<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auditorium;
use App\Models\Building;
use App\Models\WeekDay;
use Carbon\Carbon;


class AuditoriumsController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->input('name');
        $buildings = Building::all();
        return view('auditoriums.index', compact('buildings', 'name'));
    }

    public function show(int $id)
    {
        $weekMonthText = Carbon::now()->weekOfMonth;
        $nowTimeText = Carbon::now()->format('H:i:s');
        $weekDay = WeekDay::query()->where('id', Carbon::now()->dayOfWeek)->first();
        $weekDayText = $weekDay->name;

        $auditorium = Auditorium::query()->findOrFail($id);
        $weekDays = WeekDay::all();

        return view('auditoriums.show', compact('auditorium', 'weekDays', 'weekDayText', 'weekMonthText', 'nowTimeText'));
    }
}
