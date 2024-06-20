<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auditorium;
use App\Models\Building;
use Illuminate\Support\Facades\Http;

class UpdateAuditoriumsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:update-auditoriums';

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
        $response = Http::get('https://iis.bsuir.by/api/v1/auditories');

        if ($response->successful()) 
        {
            Auditorium::truncate();
            Building::truncate();

            $auditoriums = $response->json();
            $buildings = [];
            foreach ($auditoriums as $auditorium)
            {
                if (!in_array($auditorium['buildingNumber']['id'], $buildings)) {
                    $buildings[$auditorium['buildingNumber']['id']] = $auditorium['buildingNumber']['name'];
                } 
            }

            foreach ($buildings as $key => $value) 
            {
                Building::create([
                    'id' => $key,
                    'name' => $value,
                ]);
            }


            foreach ($auditoriums as $auditorium)
            {
                info($auditorium['buildingNumber']['id']);
                $res = Auditorium::create([
                    'id' => $auditorium['id'],
                    'name' => $auditorium['name'],
                    'building_id' => $auditorium['buildingNumber']['id'],
                ]);
            }
        } 
        else 
        {
            info('Updateing auditories was failed, code: '.$response->status());
        }
    }
}
