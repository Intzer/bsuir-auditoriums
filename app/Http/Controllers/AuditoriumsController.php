<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auditorium;
use App\Models\Building;

class AuditoriumsController extends Controller
{
    public function index()
    {
        $buildings = Building::all();
        return view('auditoriums.index', compact('buildings'));
    }

    public function show(int $id)
    {
    
    }
}
