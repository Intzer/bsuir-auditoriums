<?php

namespace App\Http\Controllers;

use App\Models\Path;
use Illuminate\Http\Request;
use App\Models\Auditorium;
use App\Models\Building;
use Carbon\Carbon;


class PathController extends Controller
{
    public function index()
    {
        $buildings = Building::all();
        $path = Path::all();

        $allowedBuildings = [];

        foreach ($buildings as $building) {
            foreach ($path as $entry) {
                if ($entry->building_id == $building->id) {
                    $allowedBuildings[] = $building;
                    break;
                }
            }
        }

        return view('path', ['buildings' => $allowedBuildings]);
    }
}


