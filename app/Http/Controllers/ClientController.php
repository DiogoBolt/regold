<?php

namespace App\Http\Controllers;

use App\Category;
use App\Customer;
use App\DocumentSuperType;
use App\DocumentType;
use App\Favorite;
use App\Group;
use App\Message;
use App\Order;
use App\Receipt;
use App\Salesman;
use App\User;
use App\Districts;
use App\Cities;
use App\ServiceType;
use App\ServiceTypeClient;
use App\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
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

    public function home()
    {
        $user = Auth::user();
        $client = Customer::where('id',$user->client_id)->first();

        $receiptsHACCP = Receipt::from(Receipt::alias('r'))
            ->leftJoin(DocumentType::alias('dt'), 'r.document_type_id', '=', 'dt.id')
            ->leftJoin(DocumentSuperType::alias('dst'), 'dt.superType', '=', 'dst.id')
            ->where('dst.name','HACCP')
            ->where('r.client_id',$user->client_id)
            ->where('viewed',0)
            ->count();
        $receiptsCP = Receipt::from(Receipt::alias('r'))
            ->leftJoin(DocumentType::alias('dt'), 'r.document_type_id', '=', 'dt.id')
            ->leftJoin(DocumentSuperType::alias('dst'), 'dt.superType', '=', 'dst.id')
            ->where('dst.name','Controlopragas')
            ->where('r.client_id',$user->client_id)
            ->where('viewed',0)
            ->count();
        $receiptsCont = Receipt::from(Receipt::alias('r'))
            ->leftJoin(DocumentType::alias('dt'), 'r.document_type_id', '=', 'dt.id')
            ->leftJoin(DocumentSuperType::alias('dst'), 'dt.superType', '=', 'dst.id')
            ->where('dst.name','Contabilistico')
            ->where('r.client_id',$user->client_id)
            ->where('viewed',0)
            ->count();

        return view('client.home',compact('receiptsCont','receiptsCP','receiptsHACCP'));
    }

    public function unreadMessages()
    {
        $user = Auth::user();

        $client = Customer::where('id',$user->client_id)->first();

        $messages = Message::where('receiver_id',$user->id)->where('viewed',0)->count();


        return $messages;
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        $inputs = $request->all();
        echo "<script>console.log('" . json_encode($inputs) . "');</script>";

        if($user->sales_id == null)
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
                ])->get();

        } else {

            $clients = Customer::from(Customer::alias('c'))
                ->leftJoin(User::alias('u'), 'u.client_id', '=', 'c.id')
                ->where('c.salesman',$user->sales_id)
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

        return view('client.index',compact('clients','unpaid','total', 'districts'));
    }

    public function newCustomer()
    {
        $salesman = Salesman::all();
        $districts = Districts::all();
        $serviceTypes = ServiceType::all();

        return view('client.new',compact('salesman','districts','serviceTypes'));
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
    public function verifyEmailExist($email){

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

        $client = new Customer;

        $userTypeID = UserType::where('name','Cliente')
        ->select([
            'id'
        ])->get();
        

        echo "<script>console.log('" . json_encode($inputs) . "');</script>";
        foreach($userTypeID as $typeid){
            $auxId=$typeid->id;
        }

        $client->name = $inputs['name'];
        $client->comercial_name = $inputs['invoiceName'];
        //address
        $client->address = $inputs['deliveryAddress'];
        $client->city = $inputs['city'];
        $client->postal_code = $inputs['postal_code'];
        //invoice address
        if($inputs['VerifyAdress']=="nao"){
            $client->invoice_address = $inputs['invoiceAddress'];
            $client->invoice_city = $inputs['cityInvoice'];
            $client->invoice_postal_code = $inputs['invoicePostalCode'];
        }else{
            $client->invoice_address = $client->address;
            $client->invoice_city =  $client->city;
            $client->invoice_postal_code = $client->postal_code;
        }

        //email
        $client->email = $inputs['email'];

        //invoiceEmail VerifyEmail
        if($inputs['VerifyEmail']=="nao"){
            $client->receipt_email = $inputs['invoiceEmail'];
        }else{
            $client->receipt_email = $client->email;
        }
        

        $client->nif = $inputs['nif'];
        $client->activity = $inputs['activity'];
        $client->salesman = $inputs['salesman'];
        $client->telephone = $inputs['telephone'];
        $client->payment_method = $inputs['payment_method'];
        //$client->client_type = $inputs['client_type'];
        //$client->receipt_email = $inputs['receipt_email'];
        $client->nib = $inputs['nib'];
        $client->contract_value = $inputs['value'];
        $client->regoldiID = $inputs['regoldiID'];
        $client->transport_note = $inputs['transport_note'];

        if($client->save())
        {        $user = new User;

            $user->name = $inputs['name'];
            $user->email = $inputs['email'];
            $user->userType=$auxId;
            //$user->client_id = $client->id;
            $user->userTypeID = $client->id;
            $user->password = bcrypt($inputs['password']);

            if (array_key_exists('serviceType1', $inputs)) {
                $serviceTypeClient = new ServiceTypeClient;
                $serviceTypeClient->id_client= $client->id;
                $serviceTypeClient->id_service_type=$inputs['serviceType1'];
                $serviceTypeClient->save();
            }

            if (array_key_exists('serviceType2', $inputs)) {
                $serviceTypeClient = new ServiceTypeClient;
                $serviceTypeClient->id_client= $client->id;
                $serviceTypeClient->id_service_type=$inputs['serviceType2'];
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
            }
            

            if(!$user->save())
            {
                $client->delete();
            }
        }

        $userL = Auth::user();

        //$clients = Customer::paginate(15);
        $clients = Customer::from(Customer::alias('c'))
        ->where('c.salesman',$userL->sales_id)
        ->paginate(15);

        $unpaid = 0;

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

        $total = $clients->count();
        $links = $clients->links();
        $districts = Districts::all();


        return view('client.index',compact('clients','unpaid','total','links','districts'));
    }

    public function editCustomer($id)
    {
        $client = Customer::where('id',$id)->first();
        $salesman = Salesman::all();

        return view('client.edit',compact('client','salesman'));
    }

    public function editCustomerPost(Request $request)
    {
        $inputs = $request->all();

        $client = Customer::where('id',$inputs['id'])->first();
        $user = User::where('client_id',$client->id)->first();

        $client->name = $inputs['name'];
        $client->comercial_name = $inputs['comercial_name'];
        $client->address = $inputs['address'];
        $client->invoice_address = $inputs['invoice_address'];
        $client->city = $inputs['city'];
        $client->postal_code = $inputs['postal_code'];
        $client->nif = $inputs['nif'];
        $client->email = $inputs['email'];
        $client->activity = $inputs['activity'];
        $client->salesman = $inputs['salesman'];
        $client->telephone = $inputs['telephone'];
        $client->payment_method = $inputs['payment_method'];
        $client->client_type = $inputs['client_type'];
        $client->receipt_email = $inputs['receipt_email'];
        $client->nib = $inputs['nib'];
        $client->contract_value = $inputs['value'];
        $client->regoldiID = $inputs['regoldiID'];
        $client->transport_note = $inputs['transport_note'];
        $options = [
            'cost' => 10
        ];
        $user->password = password_hash($inputs['password'], PASSWORD_BCRYPT, $options);
        $user->save();
        $client->save();
        return redirect('/clients/'.$inputs['id']);
    }


    public function deleteCustomer(Request $request) 
    {
        /* Delete user favourites */
        echo "<script>console.log(' $request->id');</script>";
        $user_favorites = Favorite::where('user_id', '=', $request->id)->delete();

        $client = Customer::where('id', $request->id)->first()->delete();
        $user_associated = User::where('userTypeID',$request->id)
        ->where('userType',4)
        ->first()->delete();

        return redirect()->to('/clients'); 
    }

    public function showCustomer($id)
    {

        $client = Customer::where('id',$id)->first();
        $types = DocumentType::all();

        $user = User::where('client_id',$client->id)->first();

        $receipts = Receipt::where('client_id',$client->id)->get();

        return view('client.show',compact('client','receipts','types','user'));
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

            $receipt->file = $filename;
            $receipt->save();

            $clientUser = User::where('client_id',$inputs['client'])->first();
            $message = new Message();
            $message->receiver_id = $clientUser->id;
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
        $user = Auth::user();
        Session::put('impersonated',$user->id);
        Auth::logout();
        Auth::loginUsingId($id);
        return redirect()->back();
    }

    public function leaveUser()
    {
        $userId = Session::get('impersonated');

        Session::forget('impersonated');
        Auth::logout();
        Auth::loginUsingId($userId);
        return redirect('/');
    }

    public function checkFirstLogin() 
    {
        $user = Auth::user();
        $customer = Customer::where('id',$user->client_id)->first();
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

    public function filterByCities(Request $request)
    {
        dd($request->all());
    }

}
