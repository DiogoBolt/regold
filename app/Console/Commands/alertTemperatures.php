<?php

namespace App\Console\Commands;

use App\ClientThermo;
use App\FridgeType;
use App\Message;
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
        $thermos = Thermo::query()->groupBy('imei')->get();

        foreach($thermos as $thermo)
        {
            $last4 = Thermo::where('imei',$thermo->imei)->orderBy('id','DESC')->take(4);
            $maxTemp = FridgeType::where('id',ClientThermo::where('imei',$thermo->imei)->first()->type)->first()->max_temp;
            $minTemp = FridgeType::where('id',ClientThermo::where('imei',$thermo->imei)->first()->type)->first()->min_temp;

            $rounds = 0;

            foreach($last4 as $last)
            {
                if($last->temperature > $maxTemp or $last->temperature < $minTemp)
                {
                    $rounds++;
                }
            }
            if($rounds == 4)
            {
                $message = new Message();
                $message->sender_id = 0;
                $message->receiver_id = ClientThermo::where('imei',$thermo->imei)->first()->user_id;
                $message->text = "A sua Arca numero :" . $thermo->imei . " encontra-se fora da temperatura esperada!";
                $message->save();
            }
        }

    }
}
