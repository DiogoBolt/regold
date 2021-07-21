<?php

namespace App\Console\Commands;

use App\AverageOrdersPaid;
use App\AverageNewCustomers;
use App\AverageOrders;
use App\ClientThermo;
use App\Customer;
use App\FridgeType;
use App\Message;
use App\Order;
use App\Salesman;
use App\SalesmanCommissions;
use App\Thermo;
use App\ThermoAverageTemperature;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class averageSalesman extends Command
{
    protected $signature = 'averageSalesman';
    protected $description = 'average Salesman';


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
        $salesmans = Salesman::all();

        foreach ($salesmans as $salesman){

            $clients = Customer::where('salesman',$salesman->id)->get();

            $totalOrders = 0;
            $totalOrdersPaid = 0;

            foreach ($clients as $client){
                $orders = Order::where('client_id',$client->id)->where('created_at','>=', \Illuminate\Support\Carbon::now()->startOfMonth())->sum('total');
                $paidOrders = Order::where('client_id',$client->id)->where('created_at','>=', \Illuminate\Support\Carbon::now()->startOfMonth())->where('status','=','paid')->sum('total');
                $totalOrders += $orders;
                $totalOrdersPaid += $paidOrders;
            }
            /*dd($totalOrders);*/ //valor total das encomendas no mes
            $average_orders = new AverageOrders();
            $average_orders->salesman = $salesman->id;
            $average_orders->average = $totalOrders;
            $average_orders->save();

            /*dd($totalPaidOrders);*/ //valor total das encomendas PAGAS no mes
            $average_orders_paid = new AverageOrdersPaid();
            $average_orders_paid->salesman = $salesman->id;
            $average_orders_paid->average = $totalOrdersPaid;
            $average_orders_paid->save();

            $newClients = Customer::where('salesman',$salesman->id)->where('created_at','>=', \Illuminate\Support\Carbon::now()->startOfMonth())->count();

            /*dd($newClients);*/ //numero clientes novos no mes
            $average_newCustomers = new AverageNewCustomers();
            $average_newCustomers->salesman = $salesman->id;
            $average_newCustomers->average = $newClients;
            $average_newCustomers->save();

            //comissões:

            if($totalOrdersPaid <= 5000){
                $commissions = 0;
            }elseif ($totalOrdersPaid > 5000 && $totalOrdersPaid < 10000){
                $commissions = $totalOrdersPaid * 0.03;
            }elseif ($totalOrdersPaid >= 10000 && $totalOrdersPaid < 15000){
                $commissions = $totalOrdersPaid * 0.04;
            }elseif ($totalOrdersPaid >= 15000 && $totalOrdersPaid < 20000){
                $commissions = $totalOrdersPaid * 0.05;
            }elseif ($totalOrdersPaid >= 20000){
                $commissions = $totalOrdersPaid * 0.075;
            }

            if($newClients <= 5){
                $contract_commissions = $newClients * 10;
            }elseif ($newClients > 5 && $newClients < 15){
                $contract_commissions = $newClients * 15;
            }elseif ($newClients >= 15){
                $contract_commissions = $newClients * 20;
            }

            $salesman_commissions = new SalesmanCommissions();
            $salesman_commissions->salesman = $salesman->id;
            $salesman_commissions->commissions = $commissions + $contract_commissions;
            $salesman_commissions->total_orders_paid = $totalOrdersPaid;
            $salesman_commissions->new_clients= $newClients;
            $salesman_commissions->save();

        }
    }
}


