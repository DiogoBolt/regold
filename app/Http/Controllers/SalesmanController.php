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



}
