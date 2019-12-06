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

    public function index(Request $request)
    {
        
        /*$contributors = User::where('client_id','!=',null)
        ->orWhere('technicalhaccp_id','!=',null)
        ->get();

        foreach($contributors as $sales)
        {
            $sales->total = SalesPayment::where('sales_id',$sales->sales_id)->where('delivered',0)->sum('value');
        }*/
        $inputs = $request->all();
        echo "<script>console.log('" . json_encode($inputs) . "');</script>";
        $contributors = User::when($request->filled('contributor'),
        function ($query) use ($inputs) {
            return $query->where('userType', $inputs['contributor']);
        })->where('userType','!=',4)
        ->where('userType','!=',5)
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

        echo "<script>console.log('$id');</script>";

        $contributorShow = User::where('userTypeID',$id)
        ->where('userType',1)
        ->first();

        echo "<script>console.log('$contributorShow->userType');</script>";
        if(Auth::user()->userType == 5 || (Auth::user()->userType == $contributorShow->userType ))
        {
            if($contributorShow->userType==1){
                
                $user = User::where('sales_id', '!=', $id)->first();
                $salesman = Salesman::where('id', $contributorShow->userTypeID)->first();
                $salesPayments = SalesPayment::where('sales_id', $id)->where('delivered', 0)->get();

                foreach($salesPayments as $payment)
                {
                    $payment->invoice =  Order::where('id',$payment->order_id)->first()->invoice_id;
                }
    
                $total = SalesPayment::where('sales_id', $id)->where('delivered', 0)->sum('value');
    
                return view('salesman.show', compact('salesman', 'salesPayments', 'user', 'total'));

            }
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

            $user->userType = 1;
            $user->userTypeID = $sales->id;

            
        }else if($inputs['UserType'] == 'Técnico HACCP'){
            echo "<script>console.log('entrei aqui mas não fiz nada');</script>";
            $technicalhaccp = new TechnicalHACCP();

            $technicalhaccp->name = $inputs['name'];
            $technicalhaccp->address = $inputs['address'];
            $technicalhaccp->city = $inputs['city'];
            $technicalhaccp->nif = $inputs['nif'];
            $technicalhaccp->postal_code = $inputs['postal_code']; 

            $technicalhaccp->save();
            $user->userType = 2;
            $user->userTypeID = $technicalhaccp->id;
        }

        $user->name = $inputs['name'];
        $user->email = $inputs['email'];
        $user->password = bcrypt($inputs['password']);

        $user->save();

       return redirect()->to('/salesman'); 
    }
    //alterar aqui 
    public function deleteSales(Request $request) 
    {
        echo "<script>console.log('$request->usertype');</script>";
        if($request->usertype == 1){
            $salesman = Salesman::where('id', $request->usertypeid)->first()->delete();
        }else if($request->usertype == 2){
            $technicalhaccp = TechnicalHACCP::where('id', $request->usertypeid)->first()->delete();
        }
        $user_associated = User::where('userTypeID',$request->usertypeid)
        ->where('userType',$request->usertype)
        ->first()->delete();
            //meter aqui o resto das verificacoes
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
