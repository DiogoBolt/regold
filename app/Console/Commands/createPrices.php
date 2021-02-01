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
        $products = Product::all();

        foreach ($products as $product)
        {
            $product->price1 = str_replace([','],['.'],$product->price1);
            $product->price2 = str_replace([','],['.'],$product->price2);
            $product->price3 = str_replace([','],['.'],$product->price3);
            $product->price4 = str_replace([','],['.'],$product->price4);
            $product->price5 = str_replace([','],['.'],$product->price5);

            $product->save();
        }

    }

}


