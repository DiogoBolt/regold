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
        $clients = Customer::all();
        $products = Product::all();

        foreach($clients as $client)
        {
            foreach($products as $product)
            {
                $pvp = ClientProduct::where('client_id',$client->id)->where('product_id',$product->id)->first();

                if(!isset($pvp))
                {
                    $newpvp = new ClientProduct;
                    $newpvp->client_id = $client->id;
                    $newpvp->product_id = $product->id;
                    $newpvp->pvp = 1;
                    $newpvp->save();
                }

            }
        }

    }
}


