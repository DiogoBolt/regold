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
use App\Districts;
use App\Cities;
use App\UserType;
use App\TechnicalHACCP;

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
        
        /*$contributors = User::where('client_id','!=',null)
        ->orWhere('technicalhaccp_id','!=',null)
        ->get();

        foreach($contributors as $sales)
        {
            $sales->total = SalesPayment::where('sales_id',$sales->sales_id)->where('delivered',0)->sum('value');
        }*/
        

        $contributors = User::where('userType','!=',4)
        ->get();

        $userstypes = UserType::all();

        foreach($contributors as $contributor){
            foreach($userstypes as $userType){
                if($contributor->userType == $userType->id){
                    $contributor->userTypeName = $userType->name;
                }
            }
        }

        return view('salesman.index', compact('contributors','userstypes'));
    }

    public function salesman($id){

        if(Auth::user()->client_id == null and (Auth::user()->sales_id == null or Auth::user()->sales_id == $id))
        {
            $user = User::where('sales_id', '!=', $id)->first();
            $salesman = Salesman::where('id', $id)->first();

            $salesPayments = SalesPayment::where('sales_id', $id)->where('delivered', 0)->get();

            foreach($salesPayments as $payment)
            {
                $payment->invoice =  Order::where('id',$payment->order_id)->first()->invoice_id;
            }

            $total = SalesPayment::where('sales_id', $id)->where('delivered', 0)->sum('value');

            return view('salesman.show', compact('salesman', 'salesPayments', 'user', 'total'));

        }else{
            return back();
        }

    }

    public function newSales()
    {
        $districts = Districts::all();
        $UserTypes = UserType::all();
        return view('salesman.new',compact('districts','UserTypes'));
    }

    public function addSales(Request $request)
    {
        $inputs = $request->all();

        echo "<script>console.log('" . json_encode($inputs) . "');</script>";
        $user = new User;

        if($inputs['UserType'] == 'Vendedor'){
            
            $sales = new Salesman();

            $sales->name = $inputs['name'];
            $sales->address = $inputs['address'];
            $sales->city = $inputs['city'];
            $sales->nif = $inputs['nif'];
            $sales->postal_code = $inputs['postal_code']; 

            $sales->save();

            $user->sales_id = $sales->id;

            
        }else if($inputs['UserType'] == 'Técnico HACCP'){
            echo "<script>console.log('entrei aqui mas não fiz nada');</script>";
            $technicalhaccp = new TechnicalHACCP();

            $technicalhaccp->name = $inputs['name'];
            $technicalhaccp->address = $inputs['address'];
            $technicalhaccp->city = $inputs['city'];
            $technicalhaccp->nif = $inputs['nif'];
            $technicalhaccp->postal_code = $inputs['postal_code']; 

            $technicalhaccp->save();

            $user->technicalhaccp_id = $$technicalhaccp->id;
        }

        $user->name = $inputs['name'];
        $user->email = $inputs['email'];
        $user->password = bcrypt($inputs['password']);

        $user->save();

       return redirect()->to('/salesman'); 
    }

    public function deleteSales(Request $request) 
    {
        $user_associated = User::where('sales_id', '=', $request->id)->first()->delete();
        $salesman = Salesman::where('id', '=', $request->id)->first()->delete();

        return redirect()->to('/salesman'); 
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
