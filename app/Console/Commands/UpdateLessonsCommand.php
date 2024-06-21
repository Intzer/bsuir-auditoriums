<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Group;
use App\Models\Lesson;
use Illuminate\Support\Facades\Http;


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

            $groups = $response->json();
            foreach ($groups as $group)
            {
                if (random_int(1, 20) == 4) exit;

                $res = Group::create([
                    'id' => $group['name'],
                    'name' => $group['facultyAbbrev'],
                ]);

                $response = Http::get('https://iis.bsuir.by/api/v1/schedule?studentGroup='.$group['name']);
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

                    $i = 1;
                    for ($i = 1; $i < 7; $i++)
                    {
                        if (isset($response['previousSchedules'][$weekDays[$i]]))
                        {
                            foreach ($response['previousSchedules'][$weekDays[$i]] as $schedule) 
                            {
                                $lesson = Lesson::create([
                                    'name' => $schedule['subjectFullName'],
                                    'start' => $schedule['startLessonTime'],
                                    'end' => $schedule['endLessonTime'],
                                    'auditorium' =>$schedule['auditories'][0],
                                    'group_id' => $group['name'],
                                    'week_day' => $i,
                                ]);
    
                                foreach ($schedule['weekNumber'] as $weekNumber) {
                                    $lesson->weekNumbers()->attach($weekNumber);
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
