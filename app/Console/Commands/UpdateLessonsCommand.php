<?php

namespace App\Console\Commands;

use App\Models\Auditorium;
use Illuminate\Console\Command;
use App\Models\Group;
use App\Models\Lesson;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;


class UpdateLessonsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:update-lessons';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = Http::get('https://iis.bsuir.by/api/v1/student-groups');
        if ($response->successful()) 
        {
            Lesson::query()->delete();
            Group::query()->delete();

            // $repeats = 0;

            $groups = $response->json();
            foreach ($groups as $group)
            {
                // $repeats += 1;
                // if ($repeats > 100) exit;

                Group::create([
                    'id' => $group['id'],
                    'name' => $group['name'],
                    'faculty_name' => $group['facultyAbbrev'],
                    'speciality_name' => $group['specialityName'],
                ]);

                $response = Http::get('https://iis.bsuir.by/api/v1/schedule?studentGroup='.$group['name']);
                $this->info("Getting schedule for ".$group['name']);
                if ($response->successful())
                {
                    $response = $response->json();

                    $weekDays = [
                        1 => "Понедельник",
                        2 => "Вторник",
                        3 => "Среда",
                        4 => "Четверг",
                        5 => "Пятница",
                        6 => "Суббота",
                    ];

                    for ($i = 1; $i < 7; $i++)
                    {
                        if (isset($response['previousSchedules'][$weekDays[$i]]))
                        {
                            foreach ($response['previousSchedules'][$weekDays[$i]] as $schedule) 
                            {
                                $lesson = Lesson::create([
                                    'group_id' => $group['id'],
                                    'name' => $schedule['subjectFullName'],
                                    'start_time' => $schedule['startLessonTime'],
                                    'end_time' => $schedule['endLessonTime'],
                                    'week_day_id' => $i,
                                    'note' => $schedule['note'] ?? null,
                                    'num_subgroup' => $schedule['numSubgroup'],
                                ]);

                                foreach ($schedule['auditories'] as $auditorium) {
                                    $auditorium_name = Str::before($auditorium, '-');
                                    $auditorium = Auditorium::query()
                                        ->where('name', $auditorium_name)
                                        ->first();

                                    if ($auditorium) {
                                        $lesson->auditoriums()->attach($auditorium->id);
                                    }
                                }
    
                                foreach ($schedule['weekNumber'] as $weekNumber) {
                                    $lesson->weeksNumbers()->attach($weekNumber);
                                }
                            }
                        }
                    }
                } 
                else
                {
                    info('Updateing lessons for group '.$group['name'].' was failed, code: '.$response->status());
                }
            }
        } 
        else 
        {
            info('Updateing groups was failed, code: '.$response->status());
        }
    }
}
