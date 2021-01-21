<?php

namespace App\Console\Commands;

use App\ClientProduct;
use App\ClientThermo;
use App\Customer;
use App\FridgeType;
use App\Message;
use App\Order;
use App\Product;
use App\Thermo;
use App\ThermoAverageTemperature;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class createPrices extends Command
{
    protected $signature = 'createPrices';
    protected $description = 'o beto é fixe';


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
       $thermos = ClientThermo::all();

       foreach($thermos as $thermo)
       {
           $user = User::where('id',$thermo->user_id)->first();
if(isset($user))
{
    $thermo->user_id = $user->client_id;
    $thermo->save();
    $this->line($user->id);
}

       }

    }
}


