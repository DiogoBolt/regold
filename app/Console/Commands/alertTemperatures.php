<?php

namespace App\Console\Commands;

use App\Thermo;
use App\ThermoAverageTemperature;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class alertTemperatures extends Command
{
    protected $signature = 'alert:temperatures';
    protected $description = 'Temperatures and Alert';


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
        $thermos = Thermo::query()->groupBy('imei');

    }


}
