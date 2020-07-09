<?php

namespace App\Console\Commands;

use App\Thermo;
use App\ThermoAverageTemperature;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateTemperatures extends Command
{
    protected $signature = 'updatetemperatures';
    protected $description = 'Update morning / afternoon average temperatures';

    private $isMorning;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $thermos = $this->getThermosRecords();
        $this->saveAverageRecords($thermos);
    }

    private function getThermosRecords()
    {
        $now = Carbon::now();
        $this->isMorning = $now->format('H') < 12;

        $start = $this->isMorning ? $now->copy()->startOfDay() : $now->copy()->startOfDay()->addHours(12);
        $end = $this->isMorning ? $now->hour(11)->minute(59)->second(59) : $now->endOfDay();

        return Thermo::query()->select([
            'client_id',
            'thermo_type',
            DB::raw('AVG(cast(temperature AS DECIMAL(4,2))) as average'),
            'imei'
        ])
            ->groupBy('imei')
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('last_read', [$start, $end]);
            })
            ->get();
    }

    private function saveAverageRecords($thermos)
    {
        foreach ($thermos as $thermo) {
            $this->isMorning ? $thermo['morning_temp'] = $thermo['average'] : $thermo['afternoon_temp'] = $thermo['average'];

            ThermoAverageTemperature::updateOrCreate(
                [
                    'client_id' => $thermo['client_id'],
                    'imei' => $thermo['imei']
                ]
                , $thermo->toArray()
            );

            $thermo = Thermo::query()
                ->where('imei', $thermo['imei'])
                ->where('created_at', '<', Carbon::now()->subHours(24))
                ->delete();
        }
    }
}
