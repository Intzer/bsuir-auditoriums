<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('task:update-auditoriums')->hourly();
Schedule::command('task:update-lessons')->hourly();