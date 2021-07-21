<?php
namespace App\Http\Controllers;
use App\AverageNewCustomers;
use App\AverageOrders;
use App\AverageOrdersPaid;
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
    public function homePage(){

        $user = Auth::user();

        if($user->userType == 1){

            $clientsOrder = 0;
            $clients_spOrder = 0;
            $clients_spfreeOrder = 0;
            $clients_sOrder = 0;
            $clients_stOrder = 0;
            $clients_tOrder = 0;


            $clients = Customer::where('salesman',$user->userTypeID)->get();
            $count_clients = count($clients);

            foreach ($clients as $client){
                $orders = Order::where('client_id',$client->id)->where('created_at','>=',Carbon::now()->startOfMonth())->count();

                if($orders == 0){
                    $clientsOrder += 1;
                }
            }

            $clients_sp = Customer::where('salesman',$user->userTypeID)->where('pack_type','sp')->get();
            $count_sp = count($clients_sp);

            foreach ($clients_sp as $client){
                $orders = Order::where('client_id',$client->id)->where('created_at','>=',Carbon::now()->startOfMonth())->count();

                if($orders == 0){
                    $clients_spOrder += 1;
                }
            }

            $clients_spfree = Customer::where('salesman',$user->userTypeID)->where('pack_type','sp free')->get();
            $count_spfree = count($clients_spfree);

            foreach ($clients_spfree as $client){
                $orders = Order::where('client_id',$client->id)->where('created_at','>=',Carbon::now()->startOfMonth())->count();

                if($orders == 0){
                    $clients_spfreeOrder += 1;
                }
            }

            $clients_s = Customer::where('salesman',$user->userTypeID)->where('pack_type','s')->get();
            $count_s = count($clients_s);

            foreach ($clients_s as $client){
                $orders = Order::where('client_id',$client->id)->where('created_at','>=',Carbon::now()->startOfMonth())->count();

                if($orders == 0){
                    $clients_sOrder += 1;
                }
            }

            $clients_st = Customer::where('salesman',$user->userTypeID)->where('pack_type','st')->get();
            $count_st = count($clients_st);

            foreach ($clients_st as $client){
                $orders = Order::where('client_id',$client->id)->where('created_at','>=',Carbon::now()->startOfMonth())->count();

                if($orders == 0){
                    $clients_stOrder += 1;
                }
            }

            $clients_t = Customer::where('salesman',$user->userTypeID)->where('pack_type','t')->get();
            $count_t = count($clients_t);

            foreach ($clients_t as $client){
                $orders = Order::where('client_id',$client->id)->where('created_at','>=',Carbon::now()->startOfMonth())->count();

                if($orders == 0){
                    $clients_tOrder += 1;
                }
            }
            $real = $this->real($user->userTypeID);
            $target = $this->target($user->userTypeID);
            $commission = $this->commission($user->userTypeID);

        }

        return view('salesman.homePage',compact('count_clients','clientsOrder','count_s','clients_sOrder','count_sp','clients_spOrder','count_spfree','clients_spfreeOrder','count_st','clients_stOrder','count_t','clients_tOrder','real','target','commission'));
    }

    public function statistics(){

        $user = Auth::user();



        return view('salesman.statistics');
    }

    public function schedule(){

        $user = Auth::user();



        return view('salesman.schedule');
    }



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
        ->where('userType','!=',6)
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
                $salesPayments = SalesPayment::where('sales_id', $user->userTypeID)->where('delivered', 0)->get();

                $orders=[];
                foreach ($salesPayments as $payment) {
                    $order = Order::from(Order::alias('o'))
                        ->leftJoin(Customer::alias('c'), 'o.client_id', '=', 'c.id')
                        ->where('o.id', $payment->order_id)
                        ->select([
                            'o.id', 'o.client_id', 'o.cart_id', 'o.total', 'o.totaliva', 'o.processed',
                            'o.receipt_id', 'o.created_at', 'c.name', 'c.regoldiID', 'o.status', 'o.invoice_id'
                        ])
                        ->first();
                        array_push($orders,$order);
                }

                $total = SalesPayment::where('sales_id', $user->userTypeID)->where('delivered', 0)->sum('value');

                return view('salesman.show', compact('salesman', 'salesPayments','user', 'total','orders'));

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
        $UserTypes = UserType::where('id','!=',6)->get();
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

        }else if($inputs['UserType']== 'Técnico Controlo de Pragas'){
            $technicalcp=new TechnicalCP();
            $technicalcp->name = $inputs['name'];
            $technicalcp->address = $inputs['address'];
            $technicalcp->city = $inputs['city'];
            $technicalcp->nif = $inputs['nif'];
            $technicalcp->postal_code = $inputs['postal_code'];
            $technicalcp->save();
            $user->userType = 3;
            $user->userTypeID = $technicalcp->id;
        }else
        {
            $user->userType=5;
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
    public function deliverSalesman(Request $request)
    {

        $inputs = $request->all();

        $idOrder = explode(' , ',$request->payOrders[0]);

        if(Auth::user()->client_id == null and Auth::user()->sales_id == null){
            foreach ($idOrder as $id){
                $salesPayments = SalesPayment::where('order_id', $id)->first();
                $salesPayments->delivered = 1;
                $salesPayments->save();
                $order = Order::where('id',$id)->first();
                $order->status = 'paid';
                $order->payment_time = now();
                $order->save();
            }
        }
        return back();
    }
    public function orderPay($id){
        $user = Auth::user();

        $order = Order::where('id',$id)->first();

        $order->status_salesman = 1;
        $order->save();

        $clientUser = Customer::where('id', $order->client_id)
            ->select([
                'ownerID','id','name'
            ])->first();

        $salesPayment = new SalesPayment;

        if($user->userType==1){
            $salesPayment->sales_id = $user->userTypeID;
            $salesPayment->order_id = $order->id;
            $salesPayment->value = number_format($order->total+$order->totaliva,2);
            $salesPayment->delivered = 0;
            $salesPayment->save();
        }else{
            $order->status='paid';
            $order->payment_time = now();
            $order->save();
        }

        $message = new Message;
        $message->sender_id = $user->id;
        $message->receiver_id = $clientUser->ownerID;
        $message->text = "O pagamento da encomenda nº" . $order->id . " do estabelecimento " . $clientUser->name . "foi recebido pelo vendedor " . $user->name . ". Obrigado.";
        $message->type = 5;
        $message->viewed = 0;
        $message->save();

        return back();
    }
    public function orderUnpay($id){
        $salesPayment = SalesPayment::where('order_id',$id)->first();
        $salesPayment->delete();

        return back();
    }

    public function teste(){

        return view('salesman.teste');
    }

    public function real($idSalesman){

        $real_orders = 0;
        $real_ordersPaid = 0;

        $clients = Customer::where('salesman',$idSalesman)->get();

        foreach ($clients as $client){

            $orders = Order::where('client_id',$client->id)->where('created_at','>=',Carbon::now()->startOfMonth())->sum('total');
            $real_orders += $orders;
            $ordersPaid = Order::where('client_id',$client->id)->where('created_at','>=',Carbon::now()->startOfMonth())->where('status','=','paid')->sum('total');
            $real_ordersPaid += $ordersPaid;
        }
        $newCustomers = Customer::where('salesman',$idSalesman)->where('created_at','>=', Carbon::now()->startOfMonth())->count();

        $real_orders =  number_format($real_orders/1000,2);
        $real_ordersPaid = number_format($real_ordersPaid/1000,2);

        return[
            $real_orders,
            $real_ordersPaid,
            $newCustomers
        ];
    }

    public function target($idSalesman){

        $average_newcustomers = AverageNewCustomers::where('salesman',$idSalesman)->sum('average');
        $average_orders = AverageOrders::where('salesman',$idSalesman)->sum('average');
        $average_ordersPaid = AverageOrdersPaid::where('salesman',$idSalesman)->sum('average');

        $n_average_newcustomers = AverageNewCustomers::where('salesman',$idSalesman)->count();
        $n_average_orders = AverageOrders::where('salesman',$idSalesman)->count();
        $n_average_ordersPaid = AverageOrdersPaid::where('salesman',$idSalesman)->count();

        if($n_average_newcustomers != 0)
            $target_newcustomers = $average_newcustomers/$n_average_newcustomers;
        else
            $target_newcustomers = 0;

        if($n_average_orders !=0)
            $target_orders = $average_orders/$n_average_orders;
        else
            $target_orders = 0;

        if($n_average_ordersPaid !=0)
            $target_ordersPaid = $average_ordersPaid/$n_average_ordersPaid;
        else
            $target_ordersPaid = 0;

        $target_newcustomers = number_format($target_newcustomers);
        $target_ordersPaid = number_format($target_ordersPaid/1000,2);
        $target_orders = number_format($target_orders/1000,2);

        return[
            $target_orders,
            $target_ordersPaid,
            $target_newcustomers
        ];
    }

    public function commission($idSalesman){

        $ordersPaid = 0;
        $ordersUnpaid = 0;

        $clients = Customer::where('salesman',$idSalesman)->get();

        foreach ($clients as $client){

            $orders = Order::where('client_id',$client->id)->where('status','=','paid')->where('payment_time','>=',Carbon::now()->startOfMonth())->sum('total');
            $ordersPaid += $orders;
            $ordersU = Order::where('client_id',$client->id)->where('status','=','waiting_payment')->sum('total');
            $ordersUnpaid += $ordersU;
        }
        $newCustomers = Customer::where('salesman',$idSalesman)->where('created_at','>=', Carbon::now()->startOfMonth())->count();

        if($ordersPaid <= 5000){
            $accumulated_commissions = 0;
        }elseif ($ordersPaid > 5000 && $ordersPaid < 10000){
            $accumulated_commissions = $ordersPaid * 0.03;
        }elseif ($ordersPaid >= 10000 && $ordersPaid < 15000){
            $accumulated_commissions = $ordersPaid * 0.04;
        }elseif ($ordersPaid >= 15000 && $ordersPaid < 20000){
            $accumulated_commissions = $ordersPaid * 0.05;
        }elseif ($ordersPaid >= 20000){
            $accumulated_commissions = $ordersPaid * 0.075;
        }

        if($newCustomers <= 5){
            $commissions_contract = $newCustomers * 10;
        }elseif ($newCustomers > 5 && $newCustomers < 15){
            $commissions_contract = $newCustomers * 15;
        }elseif ($newCustomers >= 15){
            $commissions_contract = $newCustomers * 20;
        }

        $accumulated_commissions = $accumulated_commissions + $commissions_contract;

        $orderTotal = $ordersPaid + $ordersUnpaid;

        if($orderTotal <= 5000){
            $estimated_commissions = 0;
        }elseif ($orderTotal > 5000 && $orderTotal < 10000){
            $estimated_commissions = $orderTotal * 0.03;
        }elseif ($orderTotal >= 10000 && $orderTotal < 15000){
            $estimated_commissions = $orderTotal * 0.04;
        }elseif ($orderTotal >= 15000 && $orderTotal < 20000){
            $estimated_commissions = $orderTotal * 0.05;
        }elseif ($orderTotal >= 20000){
            $estimated_commissions = $orderTotal * 0.075;
        }

        $estimated_commissions = $estimated_commissions + $commissions_contract;

        return[
            $accumulated_commissions,
            $estimated_commissions
        ];
    }

    public function prospection(){

        return view('salesman.prospection');
    }
}