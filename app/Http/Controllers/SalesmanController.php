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
use App\TechnicalCP;
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
    public function salesman($id)
    {

        $user = User::where('id', $id)
            ->first();

        if (Auth::user()->userType == 5) {
            //dd($user);
            if ($user->userType == 1) {
                $salesman = Salesman::where('id', $user->userTypeID)->first();
                $salesPayments = SalesPayment::where('sales_id', $id)->where('delivered', 0)->get();
                foreach ($salesPayments as $payment) {
                    $payment->invoice = Order::where('id', $payment->order_id)->first()->invoice_id;
                }

                $total = SalesPayment::where('sales_id', $id)->where('delivered', 0)->sum('value');

                return view('salesman.show', compact('salesman', 'salesPayments', 'user', 'total'));

            }
            if ($user->userType == 2) {

                $salesman = TechnicalHACCP::where('id', $user->userTypeID)->first();

                return view('salesman.show', compact('salesman', 'user'));
            }
            if ($user->userType == 3) {

                $salesman = TechnicalCP::where('id', $user->userTypeID)->first();

                return view('salesman.show', compact('salesman', 'user'));
            } else {
                return back();
            }
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
            $technicalhaccp = new TechnicalHACCP();
            $technicalhaccp->name = $inputs['name'];
            $technicalhaccp->address = $inputs['address'];
            $technicalhaccp->city = $inputs['city'];
            $technicalhaccp->nif = $inputs['nif'];
            $technicalhaccp->postal_code = $inputs['postal_code']; 
            $technicalhaccp->save();
            $user->userType = 2;
            $user->userTypeID = $technicalhaccp->id;

        }else if($inputs['UserType']=='Técnico Controlo de Pragas'){
            $technicalcp=new TechnicalCP();
            $technicalcp->name = $inputs['name'];
            $technicalcp->address = $inputs['address'];
            $technicalcp->city = $inputs['city'];
            $technicalcp->nif = $inputs['nif'];
            $technicalcp->postal_code = $inputs['postal_code'];
            $technicalcp->save();
            $user->userType = 3;
            $user->userTypeID = $technicalcp->id;
        }

        $user->name = $inputs['name'];
        $user->email = $inputs['email'];
        $user->userType=5;
        $user->password = bcrypt($inputs['password']);
        $user->save();
       return redirect()->to('/salesman'); 
    }
    //alterar aqui 
    public function deleteSales(Request $request) 
    {
        if($request->usertype == 1){
            $salesman = Salesman::where('id', $request->usertypeid)->first()->delete();
        }else if($request->usertype == 2){
            $technicalhaccp = TechnicalHACCP::where('id', $request->usertypeid)->first()->delete();
        }else if($request->usertype==3){
            $technicalcp=TechnicalCP::where('id',$request->usertypeid)->first()->delete();
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