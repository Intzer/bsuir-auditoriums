<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auditorium;
use App\Models\Building;
use Carbon\Carbon;


class PathController extends Controller
{
    public function index()
    {
        $buildings = Building::all();
        return view('path', compact('buildings'));
    }
}


