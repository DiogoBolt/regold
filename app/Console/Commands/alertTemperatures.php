<?php

namespace App\Console\Commands;

use App\ClientThermo;
use App\Customer;
use App\FridgeType;
use App\Message;
use App\Thermo;
use App\ThermoAverageTemperature;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
        $thermos = Thermo::query()->where('created_at', '>', Carbon::now()->subHours(7))->groupBy('imei')->get();

        foreach ($thermos as $thermo) {
            $clientThermo = ClientThermo::where('imei', $thermo->imei)->first();
            if ($clientThermo) {

                $client = Customer::where('id', $clientThermo->user_id)->first();
                if ($client) {

                    $last4 = Thermo::where('imei', $thermo->imei)->orderBy('id', 'DESC')->take(4)->get();
                    $maxTemp = FridgeType::where('id', $clientThermo->type)->first()->max_temp;
                    $minTemp = FridgeType::where('id', $clientThermo->type)->first()->min_temp;

                    $rounds = 0;


                    foreach ($last4 as $last) {
                        if ($last->temperature > $maxTemp + 3 or $last->temperature < $minTemp - 3) {
                            $rounds++;
                        }
                    }
                    if ($rounds == 4) {
                        $lastmessage = Message::where('receiver_id', $clientThermo->user_id)->orderBy('id', 'DESC')->first();
                        if (isset($lastmessage)) {
                            if ($lastmessage->created_at < Carbon::now()->subHours(12)) {
                                $message = new Message();
                                $message->sender_id = 0;
                                $message->receiver_id = $clientThermo->user_id;
                                $message->text = "A sua Arca numero :" . $clientThermo->number . " do estabelecimento " . $client->name . " encontra-se fora da temperatura esperada!";
                                $message->type = 3;
                                $message->save();

                                Mail::send('frontoffice.alertTemperatures', ['arca' => $clientThermo->number, 'estabelecimento' => $client->name], function ($m) use ($client) {
                                    $m->from('suporte@regolfood.pt', 'Temperatura fora do valor esperado');

                                    $m->to($client->email)->subject('Temperatura fora do valor esperado');
                                });
                            }
                        } else {
                            $message = new Message();
                            $message->sender_id = 0;
                            $message->receiver_id = $clientThermo->user_id;
                            $message->text = "A sua Arca numero :" . $clientThermo->number . " do estabelecimento " . $client->name . " encontra-se fora da temperatura esperada!";
                            $message->type = 3;
                            $message->save();
                            Mail::send('frontoffice.alertTemperatures', ['arca' => $clientThermo->number, 'estabelecimento' => $client->name], function ($m) use ($client) {
                                $m->from('suporte@regolfood.pt', 'Temperatura fora do valor esperado');

                                $m->to($client->email)->subject('Temperatura fora do valor esperado');
                            });
                        }
                    }

                    if (Thermo::where('imei', $thermo->imei)->orderBy('id', 'DESC')->first()->created_at < Carbon::now()->subHours(1)) {
                        $message = new Message();
                        $message->sender_id = 0;
                        $message->receiver_id = $clientThermo->user_id;
                        $message->text = "O termómetro da arca  :" . $clientThermo->number . " do estabelecimento " . $client->name . " não está a responder.";
                        $message->type = 3;
                        $message->save();
                    }
                }

            }
        }
    }
}
