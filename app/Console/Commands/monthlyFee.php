<?php

namespace App\Console\Commands;

use App\ClientThermo;
use App\Customer;
use App\FridgeType;
use App\Message;
use App\Order;
use App\Thermo;
use App\ThermoAverageTemperature;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class monthlyFee extends Command
{
    protected $signature = 'monthlyFee';
    protected $description = 'packs SPfree';


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
        $clients=Customer::where('pack_type','=','sp free')
            ->get();

        foreach ($clients as $client){
            $order = Order::where('client_id', '=', $client->id)->whereMonth('created_at', \Illuminate\Support\Carbon::now()->subMonth(1)->month)->first();
            if($order===null)
            {
                $order=new Order;
                $order->client_id=$client->id;
                if($client->escala_type=='basic'){
                    $order->total=19;
                }elseif ($client->escala_type=='premium')
                {
                    $order->total=21;
                }else{
                    $order->total=30;
                }
                $order->cart_id=null;
                $order->totaliva=$order->total*1.23;
                $order->processed=0;
                $order->status='Waiting Payment';
                $order->save();
            }
        }
    }
}


