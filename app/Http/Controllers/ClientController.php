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
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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

        $search = $inputs['search'] ?? '';

        if($user->sales_id == null)
        {
            $clients = Customer::from(Customer::alias('c'))
                ->leftJoin(User::alias('u'), 'u.client_id', '=', 'c.id')
                ->where('c.name','LIKE','%'.$search.'%')
                ->orWhere('c.id','LIKE','%'.$search.'%')
                ->select([
                    'c.id',
                    'u.id as userid',
                    'c.name',
                    'c.regoldiID',
                    'c.comercial_name',
                ])->get();

            $total = Customer::from(Customer::alias('c'))
                ->leftJoin(User::alias('u'), 'u.client_id', '=', 'c.id')
                ->where('c.name','LIKE','%'.$search.'%')
                ->orWhere('c.id','LIKE','%'.$search.'%')
                ->count();

        } else {

            $clients = Customer::from(Customer::alias('c'))
                ->leftJoin(User::alias('u'), 'u.client_id', '=', 'c.id')
                ->where('c.salesman',$user->sales_id)
                ->where(function($query) use ($search)
                {
                    $query->where('c.name','LIKE','%'.$search.'%')
                        ->orWhere('c.id','LIKE','%'.$search.'%');
                })
                ->select([
                    'c.id',
                    'u.id as userid',
                    'c.name',
                    'c.regoldiID',
                    'c.comercial_name',
                ])->get();

            $total = Customer::from(Customer::alias('c'))
                ->leftJoin(Group::alias('g'), 'c.group_id', '=', 'g.id')
                ->leftJoin(User::alias('u'), 'u.client_id', '=', 'c.id')
                ->where('c.salesman',$user->sales_id)
                ->where(function($query) use ($search)
                {
                    $query->where('c.name','LIKE','%'.$search.'%')
                        ->orWhere('c.id','LIKE','%'.$search.'%');
                })
                ->count();
        }

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

       $clients =  $clients->sortBy('order');

        return view('client.index',compact('clients','unpaid','total'));

    }


    public function newCustomer()
    {
        $groups = Group::all();
        $salesman = Salesman::all();

        return view('client.new',compact('groups','salesman'));
    }

    public function addCustomer(Request $request)
    {
        $inputs = $request->all();

        $client = new Customer;

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

        $client->save();

        $user = new User;

        $user->name = $inputs['name'];
        $user->email = $inputs['email'];
        $user->client_id = $client->id;
        $user->password = bcrypt($inputs['password']);

        $user->save();


        $clients = Customer::all();
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


        return view('client.index',compact('clients','unpaid','total'));
    }

    public function deleteCustomer(Request $request) 
    {
        /* Delete user favourites */
        $user_favorites = Favorite::where('user_id', '=', $request->id)->delete();

        $client = Customer::where('id', $request->id)->first()->delete();
        $user_associated = User::where('client_id', '=', $request->id)->first();

        return redirect()->to('/clients'); 
    }

    public function addSales(Request $request)
    {
        $inputs = $request->all();

        $sales = new Salesman();

        $sales->name = $inputs['name'];
        $sales->address = $inputs['address'];
        $sales->city = $inputs['city'];
        $sales->nif = $inputs['nif'];

        $sales->save();

        $user = new User;

        $user->name = $inputs['name'];
        $user->email = $inputs['email'];
        $user->sales_id = $sales->id;
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


    public function showCustomer($id)
    {

        $client = Customer::where('id',$id)->first();
        $types = DocumentType::all();

        $user = User::where('client_id',$client->id)->first();

        $receipts = Receipt::where('client_id',$client->id)->get();

        return view('client.show',compact('client','receipts','group','types','user'));
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
        }


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

        return view('client.index',compact('clients'));
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

}
