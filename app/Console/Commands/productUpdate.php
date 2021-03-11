<?php

namespace App\Console\Commands;


use App\ClientProduct;
use App\Customer;
use App\Product;
use Illuminate\Console\Command;


class productUpdate extends Command
{
    protected $signature = 'productUpdate';
    protected $description = 'update products';


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

        foreach ($clients as $client){
                foreach($products as $product)
                {
                    $client_product = ClientProduct::where('product_id',$product->id)->where('client_id',$client->id)->first();
                    if(!isset($client_product))
                    {
                        $clientproduct = new ClientProduct;
                        $clientproduct->product_id = $product->id;
                        $clientproduct->client_id = $client->id;
                        $clientproduct->pvp = 1;
                        $clientproduct->save();
                    }

                }
            }
        }
}


