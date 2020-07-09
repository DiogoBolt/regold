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
    protected $signature = 'alertTemperatures';
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
        $thermos = Thermo::query()->where('created_at','>',Carbon::now()->subHours(7))->groupBy('imei')->get();

        foreach($thermos as $thermo)
        {
            $clientThermo = ClientThermo::where('imei',$thermo->imei)->first();
            $last4 = Thermo::where('imei',$thermo->imei)->orderBy('id','DESC')->take(4)->get();
            $maxTemp = FridgeType::where('id',$clientThermo->type)->first()->max_temp;
            $minTemp = FridgeType::where('id',$clientThermo->type)->first()->min_temp;

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
                $message->receiver_id = $clientThermo->user_id;
                $message->text = "A sua Arca numero :" . $clientThermo->id . " encontra-se fora da temperatura esperada!";
                $message->save();
            }
        }

    }
}
