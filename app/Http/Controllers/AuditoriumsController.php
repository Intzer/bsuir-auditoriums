<?php

namespace App\Http\Controllers;

use App\Models\Path;
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
    
    public function apiAuditoriums(Request $request)
    {
        $id = $request->input('building');
        $building = Building::query()->findOrFail($id);

        $path = Path::query()
            ->where('building_id', $building->id)
            ->firstOrFail();

        // Creating floor buttons
        $map = json_decode($path->map, true);
        $floorButtons = '';
        $first = true;
        foreach ($map as $floor => $floorMap) {
            $floorButtons .= view('inc.floor_btn', ['active' => $first, 'floor' => $floor])->render();
            $first = false;
        }

        // Creating options
        $rooms = json_decode($path->rooms, true);
        $options = '';
        $first = true;
        foreach($rooms as $room) {
            $options .= view('auditoriums.inc.option', ['name' => $room['name'], 'first' => $first])->render();
            $first = false;
        }
        if (empty($options)) {
            $options = '<option disabled selected>'.__('Аудиторий нет').'</option>';
        }

        return ['options' => $options, 'building_map' => $path->map, 'building_rooms' => $path->rooms, 'floor_buttons' => $floorButtons];
    }
}
