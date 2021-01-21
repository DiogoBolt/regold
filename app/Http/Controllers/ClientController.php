<?php

namespace App\Http\Controllers;

use App\Category;
use App\ClientProduct;
use App\Customer;
use App\DocumentSuperType;
use App\DocumentType;
use App\Favorite;
use App\Group;
use App\Message;
use App\Order;
use App\Product;
use App\Receipt;
use App\Report;
use App\Salesman;
use App\TechnicalHACCP;
use App\User;
use App\Districts;
use App\Cities;
use App\ServiceType;
use App\ServiceTypeClient;
use App\UserType;
use App\Schedule;
use App\PostalCodes;
use App\ActivityClient;
use App\ControlCustomizationClients;
use App\ClientSection;
use App\Section;
use DemeterChain\C;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    private $months = [
        1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril', 5 => 'Maio',
        6 => 'Junho', 7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro', 10 => 'Outubro',
        11 => 'Novembro', 12 => 'Dezembro'
    ];
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

    public function home()
    {
        $user = Auth::user();

       if(Session::has('establismentID')){
        
            $auxClientId = Session::get('establismentID');

            $clients = Customer::where('ownerID',$user->id)
                ->select([
                    'id',
                    'name'
                ])
            ->get();

            $clientPermission=Customer::where('id',$auxClientId)
                ->first();

            $receiptsHACCP = Receipt::from(Receipt::alias('r'))
                ->leftJoin(DocumentType::alias('dt'), 'r.document_type_id', '=', 'dt.id')
                ->leftJoin(DocumentSuperType::alias('dst'), 'dt.superType', '=', 'dst.id')
                ->where('dst.name','HACCP')
                ->where('r.client_id',$auxClientId)
                ->where('viewed',0)
                ->count();
            $receiptsCP = Receipt::from(Receipt::alias('r'))
                ->leftJoin(DocumentType::alias('dt'), 'r.document_type_id', '=', 'dt.id')
                ->leftJoin(DocumentSuperType::alias('dst'), 'dt.superType', '=', 'dst.id')
                ->where('dst.name','Controlopragas')
                ->where('r.client_id',$auxClientId)
                ->where('viewed',0)
                ->count();
            $receiptsCont = Receipt::from(Receipt::alias('r'))
                ->leftJoin(DocumentType::alias('dt'), 'r.document_type_id', '=', 'dt.id')
                ->leftJoin(DocumentSuperType::alias('dst'), 'dt.superType', '=', 'dst.id')
                ->where('dst.name','Contabilistico')
                ->where('r.client_id',$auxClientId)
                ->where('viewed',0)
                ->count();
           $receiptsReg = Receipt::from(Receipt::alias('r'))
               ->leftJoin(DocumentType::alias('dt'), 'r.document_type_id', '=', 'dt.id')
               ->leftJoin(DocumentSuperType::alias('dst'), 'dt.superType', '=', 'dst.id')
               ->where('dst.name','Registos')
               ->where('r.client_id',$auxClientId)
               ->where('viewed',0)
               ->count();
                
                $services = ServiceTypeClient::where('id_client',$auxClientId)
                ->select([
                    'id_service_type',
                ])
                ->get();

               // Session::put('establismentID',$clients[0]->id);
                
                return view('client.home',compact('clients','services','receiptsCont','receiptsCP','receiptsHACCP','receiptsReg','clientPermission'));
        
        }else if(Session::has('clientImpersonatedId')){

            
            $auxClientId = Session::get('clientImpersonatedId');

            Session::forget('establismentID');

           $clientPermission=Customer::where('id',$auxClientId)
               ->first();

            $receiptsHACCP = Receipt::from(Receipt::alias('r'))
                ->leftJoin(DocumentType::alias('dt'), 'r.document_type_id', '=', 'dt.id')
                ->leftJoin(DocumentSuperType::alias('dst'), 'dt.superType', '=', 'dst.id')
                ->where('dst.name','HACCP')
                ->where('r.client_id',$auxClientId)
                ->where('viewed',0)
                ->count();
            $receiptsCP = Receipt::from(Receipt::alias('r'))
                ->leftJoin(DocumentType::alias('dt'), 'r.document_type_id', '=', 'dt.id')
                ->leftJoin(DocumentSuperType::alias('dst'), 'dt.superType', '=', 'dst.id')
                ->where('dst.name','Controlopragas')
                ->where('r.client_id',$auxClientId)
                ->where('viewed',0)
                ->count();
            $receiptsCont = Receipt::from(Receipt::alias('r'))
                ->leftJoin(DocumentType::alias('dt'), 'r.document_type_id', '=', 'dt.id')
                ->leftJoin(DocumentSuperType::alias('dst'), 'dt.superType', '=', 'dst.id')
                ->where('dst.name','Contabilistico')
                ->where('r.client_id',$auxClientId)
                ->where('viewed',0)
                ->count();
           $receiptsReg = Receipt::from(Receipt::alias('r'))
               ->leftJoin(DocumentType::alias('dt'), 'r.document_type_id', '=', 'dt.id')
               ->leftJoin(DocumentSuperType::alias('dst'), 'dt.superType', '=', 'dst.id')
               ->where('dst.name','Registos')
               ->where('r.client_id',$auxClientId)
               ->where('viewed',0)
               ->count();

                $services = ServiceTypeClient::where('id_client',$auxClientId)
                ->select([
                    'id_service_type',
                ])
                ->get();

                Session::put('establismentID',$auxClientId);

            return view('client.home',compact('services','receiptsCont','receiptsCP','receiptsHACCP','receiptsReg','clientPermission'));

        }else {
            Session::forget('establismentID');

           $clientPermission=Customer::where('id',$user->client_id)
               ->first();

            $clients = Customer::where('ownerID',$user->id)
            ->select([
                'id',
                'name'
            ])
            ->get();

            $receiptsHACCP = Receipt::from(Receipt::alias('r'))
                ->leftJoin(DocumentType::alias('dt'), 'r.document_type_id', '=', 'dt.id')
                ->leftJoin(DocumentSuperType::alias('dst'), 'dt.superType', '=', 'dst.id')
                ->where('dst.name','HACCP')
                ->where('r.client_id',$clients[0]->id)
                ->where('viewed',0)
                ->count();
            $receiptsCP = Receipt::from(Receipt::alias('r'))
                ->leftJoin(DocumentType::alias('dt'), 'r.document_type_id', '=', 'dt.id')
                ->leftJoin(DocumentSuperType::alias('dst'), 'dt.superType', '=', 'dst.id')
                ->where('dst.name','Controlopragas')
                ->where('r.client_id',$clients[0]->id)
                ->where('viewed',0)
                ->count();
            $receiptsCont = Receipt::from(Receipt::alias('r'))
                ->leftJoin(DocumentType::alias('dt'), 'r.document_type_id', '=', 'dt.id')
                ->leftJoin(DocumentSuperType::alias('dst'), 'dt.superType', '=', 'dst.id')
                ->where('dst.name','Contabilistico')
                ->where('r.client_id',$clients[0]->id)
                ->where('viewed',0)
                ->count();
           $receiptsReg = Receipt::from(Receipt::alias('r'))
               ->leftJoin(DocumentType::alias('dt'), 'r.document_type_id', '=', 'dt.id')
               ->leftJoin(DocumentSuperType::alias('dst'), 'dt.superType', '=', 'dst.id')
               ->where('dst.name','Registos')
               ->where('r.client_id',$clients[0]->id)
               ->where('viewed',0)
               ->count();
                
                $services = ServiceTypeClient::where('id_client',$clients[0]->id)
                ->select([
                    'id_service_type',
                ])
                ->get();

                Session::put('establismentID',$clients[0]->id);

            return view('client.home',compact('clients','services','receiptsCont','receiptsCP','receiptsHACCP','receiptsReg','clientPermission'));
        }
    }

    public function unreadMessages()
    {
        $user = Auth::user();
        $auxClientId = Session::get('establismentID');

        $client = Customer::where('id',$auxClientId)->first();

        $messages = Message::where('receiver_id',$user->id)->where('viewed',0)->count();

        return $messages;
    }


    //obter elementos pelo id

    public function index(Request $request)
    {
        $user = Auth::user();

        $inputs = $request->all();

        if($user->userType == 5||$user->userType==3 /*|| $user->userType == 2*/)
        {
            $clients = Customer::from(Customer::alias('c'))

                ->leftJoin(User::alias('u'), 'u.client_id', '=', 'c.id')
                ->when($request->filled('cityInvoice'), function ($query) use ($inputs) {
                    return $query->where('c.city', '=', $inputs['cityInvoice']);
                })
                ->when($request->filled('search'), function ($query) use ($inputs) {
                    return $query->where('c.name', 'LIKE', '%' . $inputs['search'] . '%')
                        ->orWhere('c.id', 'LIKE', '%' . $inputs['search'] . '%');
                })

                ->select([
                    'c.id',
                    'u.id as userid',
                    'c.name',
                    'c.regoldiID',
                    'c.comercial_name',
                    'c.city'
                ])
                ->get();
        } else {
            if($user->userType==1)
            {
                $clients = Customer::from(Customer::alias('c'))
                    ->leftJoin(User::alias('u'), 'u.client_id', '=', 'c.id')
                    ->where('c.salesman',$user->userTypeID)
                    ->when($request->filled('cityInvoice'), function ($query) use ($inputs) {
                        return $query->where('c.city', '=', $inputs['cityInvoice']);
                    })
                    ->when($request->filled('search'), function ($query) use ($inputs) {
                        return $query->where('c.name', 'LIKE', '%' . $inputs['search'] . '%')
                            ->orWhere('c.id', 'LIKE', '%' . $inputs['search'] . '%');
                    })

                    ->select([
                        'c.id',
                        'u.id as userid',
                        'c.name',
                        'c.regoldiID',
                        'c.comercial_name',
                    ])->get();
            }elseif ($user->userType==2)
            {
                $clients = Customer::from(Customer::alias('c'))
                    ->leftJoin(User::alias('u'), 'u.client_id', '=', 'c.id')

                    /*filtro clientes por tecnico

                    /*->where('c.technical_haccp',$user->userTypeID)*/
                    ->when($request->filled('cityInvoice'), function ($query) use ($inputs) {
                        return $query->where('c.city', '=', $inputs['cityInvoice']);
                    })
                    ->when($request->filled('search'), function ($query) use ($inputs) {
                        return $query->where('c.name', 'LIKE', '%' . $inputs['search'] . '%')
                            ->orWhere('c.id', 'LIKE', '%' . $inputs['search'] . '%');
                    })

                    ->select([
                        'c.id',
                        'u.id as userid',
                        'c.name',
                        'c.regoldiID',
                        'c.comercial_name',
                    ])->get();
            }
        }

        $unpaid = 0;
        $total = 15;

        foreach($clients as $client)
        {
            $orders = Order::where('client_id',$client->id)->where('processed',1)->where('created_at','>=',Carbon::now()->startOfMonth())->count();
            $current = Order::where('client_id',$client->id)->where('status','waiting_payment')->where('invoice_id','!=',null)->sum('total');

            if($orders > 0)
            {
                $client->order = 1;
            }else{
                $client->order = 0;
                $unpaid += 1;
            }
            $client->current = $current;
        }

        $districts = Districts::all();
        $clients =$clients->sortBy('order');
        $clients->values()->all();

        return view('client.index',compact('clients','unpaid','total', 'districts'));
    }

    public function indexRegolfood(Request $request)
    {
        $inputs = $request->all();

      $olderScheduled= Schedule::where('month',Carbon::now()->month)->pluck('idClient')->all();

      $clients=Customer::whereNotIn('c.id',$olderScheduled)
          ->from(Customer::alias('c'))
          ->Join(Report::alias('r'), 'r.idClient', '=', 'c.id')
          ->groupBy('r.idClient')
          ->select(['r.idClient','c.name','r.numberVisit','c.regoldiID','c.city','c.id','r.created_at'])
          ->get();

      foreach ($clients as $client)
      {
          $contract=$client->contract_type;
          $today=Carbon::now()->startOfMonth()->month;
          $nrMonths=$today-$contract;
          $abc = Report::from(Report::alias('r'))
              ->leftJoin(Customer::alias('c'),'c.id','=','r.idClient')
              ->where('r.idClient',$client->id)->whereMonth('r.created_at','<=',$nrMonths)
              ->select(['r.idClient','c.name','r.numberVisit','c.regoldiID','c.city','c.id','r.created_at'])
              ->get();
      }
          $scheduledClients=Schedule::from(Schedule::alias('s'))
              ->leftJoin(Customer::alias('c'),'s.idClient','=','c.id')
              ->when($request->filled('month'),
                  function($query) use ($inputs){
                      return $query->where('month', $inputs['month']);
                  })
              ->groupBy('s.idClient')
              ->get();

        $months = $this->months;
        $districts = Districts::all();
        $technicals=TechnicalHACCP::all();
        $cities=Cities::all();

        return view('client.indexRF',compact('clients','abc','months','scheduledClients','cities','reports','districts','technicals'));
    }

    public function saveScheduleRegolfood(Request $request,$id)
    {
        $inputs = $request->all();

        $schedule_haccp=new Schedule();
        $schedule_haccp->technical=$inputs['technical'];
        $schedule_haccp->month=Carbon::now()->month;
        $schedule_haccp->idClient=$id;
        $schedule_haccp->obs=$inputs['obs'];
        $schedule_haccp->save();

        return redirect('/clients/regolfood');
    }

    public function getSchedule()
    {
        $user = Auth::user();

        $userTypeID=User::where('id',$user->id)
            ->first();

        $scheduledClients=Schedule::from(Schedule::alias('s'))
            ->leftJoin(Customer::alias('c'),'c.id','=','s.idClient')
            ->where('s.technical',$userTypeID->userTypeID)
            ->whereDate('s.month',Carbon::now()->month)
            ->groupBy('c.id')
            ->get();

        $districts = Districts::all();
        $cities=Cities::all();

        return view('client.schedule',compact('scheduledClients','districts','cities'));
    }

    public function newCustomer()
    {
        $salesman = Salesman::all();
        $technicalhaccp = TechnicalHACCP::all();
        $districts = Districts::all();
        $serviceTypes = ServiceType::all();
        $activityTypes = ActivityClient::all();

        return view('client.new',compact('salesman','technicalhaccp','districts','serviceTypes','activityTypes'));
    }

    public function getCitiesByDistrict($id)
    {
        $cities = Cities::from(Cities::alias('c'))
        ->where('c.id_district',$id)
        ->select([
            'c.id',
            'c.name',
        ])->get();

        return $cities;

    }

    //funcao para verificar se o email é unico
    /*public function verifyEmailExist($email){

        $count1 = User::from(User::alias('u'))
        ->where('u.email',$email)
        ->count();

        $count2 = Costumer::from(Costumer::alias('c'))
        ->where('c.receipt_email',$email)
        ->count();

        if($count == 0 && $count2 == 0){
            return true;
        }else{
            return false;
        }
    }*/

    //verificar se já existe um user com o email
    
    public function verifyEmailExist($email){
        $count = User::from(User::alias('u'))
        ->where('u.email',$email)
        ->where('u.userType',4)
        ->count();
        if($count == 0){
            return 1;
        }else{
            return 0;
        }
    }

    //funcao para verificar se o email é unico
    public function verifyNifExist($nif){
        $count = Costumer::from(Costumer::alias('c'))
        ->where('c.nif',$nif)
        ->count();

        if($count == 0){
            return true;
        }else{
            return false;
        }
    }

    //função para verificar se o idRegoldi é unico
    public function verifyIdRegoldiExist($idRegoldi){
        $count = Costumer::from(Costumer::alias('c'))
        ->where('c.regoldiID',$idRegoldi)
        ->count();

        if($count == 0){
            return true;
        }else{
            return false;
        }
    }

    public function addCustomer(Request $request)
    {
        $inputs = $request->all();

        //Registar o user
        $user = new User;
        $establisment = new Customer;

        if( $inputs['verifyHaveRegister']=='nao'){
            $user->name = $inputs['ownerName'];
            $user->sex = $inputs['sex'];
            $user->email = $inputs['loginMail'];
            $user->userType=4;
            $user->password = bcrypt($inputs['password']);
            $user->pin=bcrypt($inputs['pin']);
            $user->save();
            $establisment->ownerID=$user->id;
        }else{
            $idEmail = User::where('email',$inputs['registedMail'])
            ->select([
                'id',
            ])->first();
            $establisment->ownerID=$idEmail->id;
        }
        //Registar o establecimento
        $establisment->name = $inputs['name'];
        $establisment->comercial_name = $inputs['invoiceName'];

        //address
        $establisment->address = $inputs['deliveryAddress'];
        $establisment->city = $inputs['city'];
        $establisment->postal_code = $inputs['postal_code'];

        //invoice address
        if($inputs['VerifyAdress']=="nao"){
            $establisment->invoice_address = $inputs['invoiceAddress'];
            $establisment->invoice_city = $inputs['cityInvoice'];
            $establisment->invoice_postal_code = $inputs['invoicePostalCode'];
        }else{
            $establisment->invoice_address = $establisment->address;
            $establisment->invoice_city =  $establisment->city;
            $establisment->invoice_postal_code = $establisment->postal_code;
        }

        $establisment->email = $user->email;

        if($inputs['VerifyEmail']==true){
            $establisment->receipt_email = $user->email;
        }else{
            $establisment->receipt_email = $inputs['invoiceEmail'];
        }

        //email
        $establisment->nif = $inputs['nif'];
        $establisment->salesman = $inputs['salesman'];
        $establisment->telephone = $inputs['telephone'];
        $establisment->activity=1;

        //packs

        $establisment->pack_type = $inputs['packs'];
        if(isset($inputs['serviceType'])==0) $establisment->service_type = null; else $establisment->service_type =$inputs['serviceType'];
        if(isset($inputs['haccp_visits'])==0) $establisment->haccp_visits = null; else $establisment->haccp_visits=$inputs['haccp_visits'];
        if(isset($inputs['cp_visits'])==0) $establisment->cp_visits = null; else $establisment->cp_visits=$inputs['cp_visits'];
        if(isset($inputs['payment_method'])==0) $establisment->payment_method = null; else $establisment->payment_method=$inputs['payment_method'];
        if(isset($inputs['value'])==0) $establisment->contract_value = null; else $establisment->contract_value=$inputs['value'];
        if(isset($inputs['escalao'])==0)
            $establisment->escala_type = null;
        elseif($inputs['packs']=='sp free'){
            $establisment->escala_type=$inputs['escalao'];
            switch ($inputs['escalao']) {
                case 'basic':
                    $establisment->contract_value = 30.90;
                    $establisment->haccp_visits = 2;
                    $establisment->cp_visits = 1;
                    $establisment->payment_method='Debito Direto';
                    break;
                case 'premium':
                    $establisment->contract_value = 40.90;
                    $establisment->haccp_visits = 3;
                    $establisment->cp_visits = 2;
                    $establisment->payment_method='Debito Direto';
                    break;
                case 'gold':
                    $establisment->contract_value = 50.90;
                    $establisment->haccp_visits = 4;
                    $establisment->cp_visits = 3;
                    $establisment->payment_method='Debito Direto';
                    break;
            }
        }else{
            $establisment->escala_type=$inputs['escalao'];
            switch ($inputs['escalao']) {
                case 'basic':
                    $establisment->contract_value = 29.90;
                    $establisment->haccp_visits = 2;
                    $establisment->cp_visits = 1;
                    $establisment->payment_method='Debito Direto';
                    break;
                case 'premium':
                    $establisment->contract_value = 39.90;
                    $establisment->haccp_visits = 3;
                    $establisment->cp_visits = 2;
                    $establisment->payment_method='Debito Direto';
                    break;
                case 'gold':
                    $establisment->contract_value = 49.90;
                    $establisment->haccp_visits = 4;
                    $establisment->cp_visits = 3;
                    $establisment->payment_method='Debito Direto';
                    break;
            }

        }
        if(isset($inputs['nib'])==0) $establisment->nib = null; else $establisment->nib=$inputs['nib'];
        if(isset($inputs['n_thermos'])==0) $establisment->n_thermos=null; else $establisment->n_thermos=$inputs['n_thermos'];

        //fim packs

        //permissoes
        if($inputs['packs']=='sp'||$inputs['packs']=='sp free'||$inputs['packs']=='st')
            $establisment->permission=4;
        elseif ($inputs['packs']=='s'&&$inputs['serviceType']=='haccp')
            $establisment->permission=3;
        elseif ($inputs['packs']=='s'&&$inputs['serviceType']=='cp')
            $establisment->permission=2;
        elseif($inputs['packs']=='t')
            $establisment->permission=1;
        else
            $establisment->permission=4;
        //fim de permissoes

        $establisment->regoldiID = $inputs['regoldiID'];
        $establisment->transport_note = $inputs['transport_note'];
        $establisment->save();

        if( $inputs['verifyHaveRegister']=='nao'){
            $user->client_id = $establisment->id;
            $user->save();
        }

        $qtd = Section::where('activityClientId',$establisment->activity)->count();

        $ControlCustomizationClient = new ControlCustomizationClients;
        $ControlCustomizationClient->idClient=$establisment->id;

        if($qtd == 1){

            $clientSection=new ClientSection;
            $clientSection->id_client=$establisment->id;

            $section=Section::where('activityClientId',$establisment->activity)->first();
            $clientSection->id_section=$section->id;
            $clientSection->designation=$section->name;

            $clientSection->save();

            $ControlCustomizationClient->personalizeSections=1;
            $ControlCustomizationClient->save();
        }else{
            $ControlCustomizationClient->save();
        }

        $products = Product::all();
        foreach($products as $product)
        {
                $newpvp = new ClientProduct;
                $newpvp->client_id = $establisment->id;
                $newpvp->product_id = $product->id;
                $newpvp->pvp = 1;
                $newpvp->save();
        }

        //melhorar isto
        /*if (array_key_exists('serviceType1', $inputs)) {
            $serviceTypeClient = new ServiceTypeClient;
            $serviceTypeClient->id_client= $establisment->id;
            $serviceTypeClient->id_service_type=$inputs['serviceType1'];
            $serviceTypeClient->save();
        }

        if (array_key_exists('serviceType3', $inputs)) {
            $serviceTypeClient = new ServiceTypeClient;
            $serviceTypeClient->id_client= $establisment->id;
            $serviceTypeClient->id_service_type=$inputs['serviceType3'];
            $serviceTypeClient->save();
        }

        if (array_key_exists('serviceType4', $inputs)) {
            $serviceTypeClient = new ServiceTypeClient;
            $serviceTypeClient->id_client= $establisment->id;
            $serviceTypeClient->id_service_type=$inputs['serviceType4'];
            $serviceTypeClient->save();
        }*/
       
        $userL = Auth::user();

        if($userL->userType==5){
            $clients = Customer::all();
        }else if($userL->userType==1){
            $clients = Customer::from(Customer::alias('c'))
            ->where('c.salesman',$userL->userTypeID)
            ->get();
        }else if($userL->userType==2)
        {
            $clients = Customer::from(Customer::alias('c'))
                ->where('c.technical_haccp',$userL->userTypeID)
                ->get();
        }

        $unpaid = 0;
        $total = $clients->count();
        $districts = Districts::all();

        return redirect('/clients');
    }

    public function editCustomer($id)
    {
        $client = Customer::where('id',$id)->first();
        $salesman = Salesman::all();
        $districts = Districts::all();
        $serviceTypes = ServiceType::all();
        $activityTypes = ActivityClient::all();

        $auxDistrict=$this->getCitiesById($client->city)->id_district;
        $auxDristrictInvoice= $this->getCitiesById($client->invoice_city)->id_district;
        
        $client->district = $auxDistrict;
        $client->invoice_district = $auxDristrictInvoice;

        //dd($this->getParishNameByPostalCode('4809-011'));
        
        $client->client_type = $this->getServiceTypeByUserID($id);
        $client->parish =$this->getParishNameByPostalCode($client->postal_code);
        $client->parishInvoice =$this->getParishNameByPostalCode($client->invoice_postal_code);
        $client->allCities=$this->getAllCitiesByDistrict($auxDistrict);
        $client->allCitiesInvoice=$this->getAllCitiesByDistrict($auxDristrictInvoice);

        return view('client.edit',compact('client','salesman','districts','serviceTypes','activityTypes'));
    }

    public function editCustomerPost(Request $request)
    {
        $inputs = $request->all();

        $client = Customer::where('id',$inputs['id'])->first();
        $user = User::where('id',$client->ownerID)->first();

        $client->name = $inputs['name'];
        $client->comercial_name = $inputs['invoiceName'];

        //morada de entrega
        $client->address = $inputs['deliveryAddress'];
        $client->city = $inputs['city'];
        $client->postal_code = $inputs['postal_code'];

        //morada de faturacao
        $client->invoice_address = $inputs['deliveryAddress'];
        $client->invoice_city = $inputs['cityInvoice'];
        $client->invoice_postal_code = $inputs['invoicePostalCode'];

        $client->nif = $inputs['nif'];
        //$client->email = $inputs['email'];
        /*$client->activity = $inputs['activity'];*/
        $client->salesman = $inputs['salesman'];
        /*$client->technical_haccp=$inputs['technical'];*/
        $client->telephone = $inputs['telephone'];
        $client->payment_method = $inputs['payment_method'];
        $client->pvp = $inputs['pvp'];
        //$client->client_type = $inputs['client_type'];
        $client->receipt_email = $inputs['invoiceEmail'];
        $client->nib = $inputs['nib'];
        $client->contract_value = $inputs['value'];
        $client->regoldiID = $inputs['regoldiID'];
        $client->transport_note = $inputs['transport_note'];
        /*$type = ServiceTypeClient::where('id_client', $inputs['id'])->delete();
           //melhorar isto
           if (array_key_exists('serviceType1', $inputs)) {
            $serviceTypeClient = new ServiceTypeClient;
            $serviceTypeClient->id_client= $client->id;
            $serviceTypeClient->id_service_type=$inputs['serviceType1'];
            $serviceTypeClient->save();
        }

        if (array_key_exists('serviceType3', $inputs)) {
            $serviceTypeClient = new ServiceTypeClient;
            $serviceTypeClient->id_client= $client->id;
            $serviceTypeClient->id_service_type=$inputs['serviceType3'];
            $serviceTypeClient->save();
        }

        if (array_key_exists('serviceType4', $inputs)) {
            $serviceTypeClient = new ServiceTypeClient;
            $serviceTypeClient->id_client= $client->id;
            $serviceTypeClient->id_service_type=$inputs['serviceType4'];
            $serviceTypeClient->save();
        }*/
        $options = [
            'cost' => 10
        ];
        if($inputs['password']!=""){
            $user->password = password_hash($inputs['password'], PASSWORD_BCRYPT, $options);
            $user->save();
        }
        if($inputs['pin']!=""){
            $user->pin=password_hash($inputs['pin'], PASSWORD_BCRYPT, $options);
            $user->save();
        }
        $client->save();
        return redirect('/clients/'.$inputs['id']);
    }

    public function deleteCustomer(Request $request) 
    {
        /* Delete user favourites */
        $user_favorites = Favorite::where('user_id', '=', $request->id)->delete();
        $auxIDOwner = Customer::where('id',$request->id)
        ->select([
            'ownerID',
        ])->first();
        $client = Customer::where('id', $request->id)->first()->delete();
        $aux= Customer::where('ownerID', $request->ownerID)->count();
        if($aux==1){
            $user_associated = User::where('id',$auxIDOwner->ownerID)->first()->delete();
        }
        return redirect()->to('/clients'); 
    }

    public function showCustomer($id)
    { 
        Session::put('clientImpersonatedId',$id);
        $client = Customer::where('id',$id)->first();
        //morada
        $auxCity = $this->getCitiesById($client->city);
        $client->city = $auxCity->name;
        $client->district = $this->getDistrictsById($auxCity->id_district);

        $auxCityInvoice = $this->getCitiesById($client->invoice_city);
        $client->invoice_city = $auxCityInvoice->name;
        $client->invoice_district = $this->getDistrictsById($auxCity->id_district);

        $client->salesman=$this->getSalesmanNameById($client->salesman);
        $client->client_type=$this->getServiceTypeNameByID($this->getServiceTypeByUserID($id));
        
        $client->activityType=ActivityClient::where('id',$client->activity)
        ->select(['designation',])
        ->pluck('designation')
        ->first();

        $types = DocumentType::all();
       
        $user = User::where('id',$client->ownerID)->first();

        $receipts = Receipt::where('client_id',$client->id)->get();

        return view('client.show',compact('client','receipts','types','user'));
    }

    //retornar o nome da cidade pelo id
    private function getCitiesById($id){
        $citiesName= Cities::where('id',$id)
        ->first();
        return $citiesName;
    }

    //retorna o nome do distrito pelo id
    private function getDistrictsById($id){
        $districtsName=Districts::where('id',$id)
        ->select([
            'name',
        ])->first();
        return $districtsName->name;
    }

    //retornar o nome do vendedor pelo id
    private function getSalesmanNameById($id){
        $salesmanName = Salesman::where('id',$id)
        ->select([
            'name'
        ])->first();
        return $salesmanName->name;
    }

    //retorna o email do user pelo id
    private function getEmailUserById($id){
    }

    //retornar o tipo de serviço por client
    private function getServiceTypeByUserID($id){
        $auxServiceClientType = ServiceTypeClient::where('id_client',$id)
        ->select([
            'id_service_type'
        ])
        ->get();
        return $auxServiceClientType;
    }

    //retorna o nome do tipo de serviço
    private function getServiceTypeNameByID($ids){
        $ServiceTypeNames = array();
        for($i=0; $i<count($ids); $i++){
            $auxId=$ids[$i]->id_service_type;
            $aux = ServiceType::where('id',$auxId)
            ->select([
                'name'
            ])
            ->first();
            $aux123=$aux->name;
            $name=$aux->name;
            array_push($ServiceTypeNames,$name);
        }
        return $ServiceTypeNames;
    }

    //retorna o nome da freguesia pelo codigo postal
    private function getParishNameByPostalCode($postalCode){

        $parishName=PostalCodes::where('postal_code',$postalCode)->first();

        if($parishName==null)
            return $parishName='Localidade não encontrada';
        else
        return $parishName->name;
    }

    //retornar todas as cidades de um distrito
    private function getAllCitiesByDistrict($id){
        $cities=Cities::where('id_district',$id)->get();
        return $cities;
    }

    public function addReceipt(Request $request)
    {
        $inputs = $request->all();
        if($request->hasfile('receipt') and Customer::where('id',$inputs['client'])->first() != null)
        {
            $receipt = new Receipt;
            $receipt->client_id = $inputs['client'];
            $receipt->name = date('Y-m-d');
            $receipt->document_type_id = $inputs['type'];
            $receipt->viewed = 0;

            $file = $request->file('receipt');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = $file->getClientOriginalName().'.'.$extension;
            $file->move('uploads/'.$inputs['client'].'/', $filename);

            //TODO Envio de email
            //dd($inputs['client']);
            $receipt->file = $filename;
            $receipt->save();

            $clientUser = Customer::where('id',$inputs['client'])
            ->select([
                'ownerID'
            ])->first();

            $message = new Message();
            $message->receiver_id = $clientUser->ownerID;
            $message->sender_id = Auth::user()->id;
            $message->text = "Foi adicionado um documento à sua conta";
            $message->viewed = 0;
            $message->save();
        }
        return back();
    }

    public function groups()
    {
        $groups = Group::query()->orderBy('next_visit')->get();

        return view('group.index',compact('groups'));
    }

    public function newGroup()
    {
        return view('group.new');
    }

    public function addGroup(Request $request)
    {
        $inputs = $request->all();

        $group = new Group;
        $group->name = $inputs['name'];
        $group->visit_time = $inputs['visit_time'];
        $group->next_visit = $inputs['next_visit'];
        $group->order_deadline = Carbon::parse($inputs['next_visit'])->subDay(4);
        $group->save();

        $groups = Group::all();

        return view('group.index',compact('groups'));
    }

    public function editGroup($id)
    {
        $group = Group::where('id',$id)->first();

        return view('group.edit',compact('group'));
    }

    public function editGroupPost(Request $request)
    {
        $inputs = $request->all();

        $group = Group::where('id',$inputs['id'])->first();

        $group->name = $inputs['name'];
        $group->details = $inputs['details'];
        $group->visit_time = $inputs['visit_time'];
        $group->next_visit = $inputs['next_visit'];
        $group->order_deadline = Carbon::parse($inputs['next_visit'])->subDay(4);
        $group->save();

        $groups = Group::query()->orderBy('next_visit')->get();

        return view('group.index',compact('groups'));
    }

    public function clientsByGroup($id)
    {
        $user = Auth::user();
        if($user->sales_id == null)
        {
            $clients = Customer::from(Customer::alias('c'))
                ->leftJoin(Group::alias('g'), 'c.group_id', '=', 'g.id')
                ->where('g.id',$id)
                ->select([
                    'c.id',
                    'g.id as groupid',
                    'c.name',
                    'g.name as group',
                ])->get();
        }else{

            $clients = Customer::from(Customer::alias('c'))
                ->leftJoin(Group::alias('g'), 'c.group_id', '=', 'g.id')
                ->where('c.salesman',$user->sales_id)
                ->where('g.id',$id)
                ->select([
                    'c.id',
                    'g.id as groupid',
                    'c.name',
                    'g.name as group',
                ])->get();
        }
        $districts = Districts::all();

        return view('client.index',compact('clients','districts'));
    }

    public function processGroup($id)
    {
        $group = Group::where('id',$id)->first();

        switch ($group->visit_time) {
            case 'Mensal':
                $group->next_visit = Carbon::parse($group->next_visit)->addMonth(1);
                break;
            case 'Trimestral':
                $group->next_visit = Carbon::parse($group->next_visit)->addMonth(3);
                break;
            case 'Semestral':
                $group->next_visit = Carbon::parse($group->next_visit)->addMonth(6);
                break;
        }
        $group->save();

    }

    public function documentTypes()
    {
        $documentTypes = DocumentType::all();

        return view('documents.index',compact('documentTypes'));
    }

    public function newDocumentType()
    {
        $types = DocumentSuperType::all();

        return view('documents.new',compact('types'));
    }

    public function addDocument(Request $request)
    {
        $inputs = $request->all();

        $type = new DocumentType;

        $type->name = $inputs['name'];
        $type->superType = $inputs['type'];

        $type->save();

        $documentTypes = DocumentType::all();

        return view('documents.index',compact('documentTypes'));

    }

    public function showDocument($id)
    {
        $type = DocumentType::where('id',$id)->first();

        return view('documents.edit',compact('type'));
    }

    public function editDocument(Request $request)
    {
        $inputs = $request->all();
        $type = DocumentType::where('id',$inputs['id'])->first();
        $type->name = $inputs['name'];
        $type->save();

        $documentTypes = DocumentType::all();

        return view('documents.index',compact('documentTypes'));
    }

    public function Categories()
    {
        $documentTypes = Category::all();

        return view('categories.index',compact('documentTypes'));
    }

    public function newCategory()
    {
        return view('categories.new');
    }

    public function addCategory(Request $request)
    {
        $inputs = $request->all();

        $category = new Category;
        $category->name = $inputs['name'];
        $category->save();
        $documentTypes = Category::all();

        return view('categories.index',compact('documentTypes'));
    }

    public function showCategory($id)
    {
        $type = Category::where('id',$id)->first();

        return view('categories.edit',compact('type'));
    }

    public function editCategory(Request $request)
    {
        $inputs = $request->all();
        $type = Category::where('id',$inputs['id'])->first();

        $type->name = $inputs['name'];
        $type->save();

        $documentTypes = Category::all();

        return view('categories.index',compact('documentTypes'));
    }

    public function deleteCategory($id)
    {
        $category = Category::where('id',$id)->first();

        if(!isset($category))
            return back();

        $category->delete();

        return back();
    }

    public function deleteDocumentType($id)
    {
        $type = DocumentType::where('id',$id)->first();

        if(!isset($type))
            return back();

        $type->delete();

        return back();
    }

    public function impersonateClient($id)
    {
        $idUser=Customer::where('id',$id)
        ->select([
            'ownerID',
        ])
        ->first();
        $user = Auth::user();
        Session::put('impersonated',$user->id);
        //Session::put('establismentID',$id);
        Session::put('clientImpersonatedId',$id);
        Auth::logout();
        Auth::loginUsingId($idUser->ownerID);
        return redirect('/home');
    }

    public function leaveUser()
    {
        $userId = Session::get('impersonated');
        Session::forget('impersonated');
        Session::forget('establismentID');
        Session::forget('clientImpersonatedId');
        Auth::logout();
        Auth::loginUsingId($userId);
        return redirect('/');
    }

    public function checkFirstLogin() 
    {
        $user = Auth::user();
        $customer = User::where('id',$user->id)->first();
        $first_time_login = 0;

        if (!$customer->first_login) {
            $first_time_login = 1;
            $customer->first_login = 1; 
            $customer->save(); 
        }
        return $first_time_login;
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:5',
            'confirm' => 'required|same:password',
        ],[
            'password.required' => 'Por favor preencha o campo de password.',
            'confirm.required' => 'Por favor preencha o campo de confirmar password.',
            'password.min' => 'A password convém ter um mínimo de 5 caracteres.',
            'confirm.same' => 'As duas passwords não coincidem.'
        ]);

        if ($validator->fails()) {
            return ['error' => $validator->errors()->first()];
        }

        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();

        return ['success' => 'Password alterada com sucesso.'];
    }

    public function getParishbyPostalCode($postalCode){
        $parish = PostalCodes::where('postal_code',$postalCode)
        ->select([
            'name',
        ])->first();

        return $parish;
    }

    public function filterByCities(Request $request)
    {
        dd($request->all());
    }

    //funcão para guardar o id da loja numa var de sessão
    public function addSessionVar($id){
        Session::put('establismentID',$id);
    }

    //função para apagar uma variavel de sessão
    public function deleteSessionVar($id){
        Session::forget('establismentID');
    }

    public function editClientPrices($id)
    {
        $client = Customer::where('id',$id)->first();
        $pvps = ClientProduct::where('client_id',$id)->get();
        foreach($pvps as $pvp)
        {
            $pvp->name = Product::where('id',$pvp->product_id)->first()->name;
        }
        return view('client.editPrices',compact('client','pvps'));
    }

    public function editClientPvp(Request $request)
    {
        $inputs = $request->all();

        $pvp = ClientProduct::where('id',$inputs['id'])->first();
        $pvp->pvp = $inputs['value'];
        $pvp->save();

    }


}
