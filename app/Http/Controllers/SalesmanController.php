<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Category;
use App\Customer;
use App\DocumentType;
use App\Group;
use App\Message;
use App\Order;
use App\OrderLine;
use App\Product;
use App\Receipt;
use App\Salesman;
use App\SalesPayment;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class SalesmanController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $salesman = User::where('sales_id','!=',null)->get();

        foreach($salesman as $sales)
        {
            $sales->total = SalesPayment::where('sales_id',$sales->id)->where('delivered',0)->sum('value');
        }

        return view('salesman.index', compact('salesman'));
    }

    public function salesman($id){

        if(Auth::user()->client_id == null and (Auth::user()->sales_id == null or Auth::user()->sales_id == $id))
        {
            $user = User::where('sales_id', '!=', $id)->first();
            $salesman = Salesman::where('id', $id)->first();

            $salesPayments = SalesPayment::where('sales_id', $id)->where('delivered', 0)->get();

            $total = SalesPayment::where('sales_id', $id)->where('delivered', 0)->sum('value');

            return view('salesman.show', compact('salesman', 'salesPayments', 'user', 'total'));

        }else{
            return back();
        }

    }

    public function newSales()
    {
        return view('salesman.new');
    }


    public function deliverSalesman($id)
    {
        if(Auth::user()->client_id == null and Auth::user()->sales_id == null) {
            $salesPayments = SalesPayment::where('sales_id', $id)->where('delivered', 0)->get();

            foreach ($salesPayments as $payment) {
                $payment->delivered = 1;
                $payment->save();
            }
        }

        return back();
    }



}
