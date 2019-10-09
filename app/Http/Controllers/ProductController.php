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

class ProductController extends Controller
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
        $products = Product::all();

        return view('product.index', compact('products'));
    }


    public function newProduct()
    {
        $categories = Category::all();
        return view('product.new', compact('categories'));
    }

    public function addProduct(Request $request)
    {
        $inputs = $request->all();

        if ($request->hasfile('foto')) {
            $product = new Product;


            $product->name = $inputs['name'];
            $product->price1 = $inputs['price1'];
            $product->price2 = $inputs['price2'];
            $product->price3 = $inputs['price3'];
            $product->amount2 = $inputs['amount2'];
            $product->amount3 = $inputs['amount3'];
            $product->details = $inputs['details'];
            $product->ref = $inputs['ref'];
            $product->category = $inputs['category'];


            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = $inputs['name'] . date('Y-m-d') . '.' . $extension;
            $file->move('uploads/products/', $filename);

            $product->file = $filename;


            $file = $request->file('manual');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = $inputs['name'] . 'tecnica' . date('Y-m-d') . '.' . $extension;
            $file->move('uploads/products/', $filename);

            $product->manual = $filename;

            $file = $request->file('seguranca');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = $inputs['name'] . 'seguranca' . date('Y-m-d') . '.' . $extension;
            $file->move('uploads/products/', $filename);

            $product->seguranca = $filename;
            $product->save();
        }
        $products = Product::all();
        return view('product.index', compact('products'));

    }

    public function editProduct($id)
    {

        $product = Product::where('id', $id)->first();
        $categories = Category::all();

        return view('product.edit', compact('product', 'categories'));
    }

    public function deleteProduct(Request $request)
    {
        $product = Product::where('id', $request->id)->first();
        $product->delete();

        return redirect()->to('/products'); 
    }

    public function editProductPost(Request $request)
    {
        $inputs = $request->all();

        $product = Product::where('id', $inputs['id'])->first();

        $product->name = $inputs['name'];
        $product->price1 = $inputs['price1'];
        $product->price2 = $inputs['price2'];
        $product->price3 = $inputs['price3'];
        $product->amount2 = $inputs['amount2'];
        $product->amount3 = $inputs['amount3'];
        $product->ref = $inputs['ref'];
        $product->details = $inputs['details'];
        $product->category = $inputs['category'];

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = $inputs['name'] . date('Y-m-d') . '.' . $extension;
            $file->move('uploads/products/', $filename);

            $product->file = $filename;
        }

        if ($request->hasFile('manual')) {
            $file = $request->file('manual');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = $inputs['name'] . 'tecnica' . date('Y-m-d') . '.' . $extension;
            $file->move('uploads/products/', $filename);

            $product->manual = $filename;
        }


        if ($request->hasFile('seguranca')) {
            $file = $request->file('seguranca');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = $inputs['name'] . 'seguranca' . date('Y-m-d') . '.' . $extension;
            $file->move('uploads/products/', $filename);

            $product->seguranca = $filename;
        }

        $product->save();

        $categories = Category::all();
        return view('product.edit', compact('product', 'categories'));

    }

    public function showOrders()
    {
        $user = Auth::user();
        if ($user->sales_id == null) {
            $orders = Order::from(Order::alias('o'))
                ->leftJoin(Customer::alias('c'), 'o.client_id', '=', 'c.id')
                ->where('processed',0)
                ->select([
                    'o.id', 'o.client_id', 'o.cart_id', 'o.total', 'o.totaliva', 'o.processed',
                    'o.receipt_id','o.created_at','c.comercial_name','c.regoldiID','o.status','o.invoice_id'
                ])
                ->orderBy('o.id', 'DESC')->paginate(25);
        } else {
            $orders = Order::from(Order::alias('o'))
                ->leftJoin(Customer::alias('c'), 'o.client_id', '=', 'c.id')
                ->where('c.salesman', $user->sales_id)
                ->where('processed',0)
                ->select([
                    'o.id', 'o.client_id', 'o.cart_id', 'o.total', 'o.totaliva', 'o.processed',
                    'o.receipt_id','o.created_at','c.comercial_name','c.regoldiID','o.status','o.invoice_id'
                ])
                ->orderBy('o.id', 'DESC')->paginate(25);
        }

        foreach($orders as $order)
        {
            $order->receipt = Receipt::where('id',$order->receipt_id)->first()->file ?? null;
            $order->invoice = Receipt::where('id',$order->invoice_id)->first()->file ?? null;
        }

        return view('orders.index', compact('orders'));
    }

    public function filterOrders(Request $request) 
    {

        $user = Auth::user();
        $filteredOrders  =  Order::from(Order::alias('o'))
                            ->leftJoin(Customer::alias('c'), 'o.client_id', '=', 'c.id')
                            ->select([
                                'o.id', 'o.client_id', 'o.cart_id', 'o.total', 'o.totaliva', 'o.processed',
                                'o.receipt_id','o.created_at','c.name','c.regoldiID','o.status','o.invoice_id'
                            ]);

        if($user->sales_id) { $filteredOrders->where('c.salesman', $user->sales_id);}                    
        
        if ($request->filled('client')) { $filteredOrders->where('c.name', 'like', '%' . $request->client . '%'); }

        if ($request->filled('payment_method')) { $filteredOrders->where('c.payment_method', '=', $request->payment_method); }

        if ($request->filled('status')) { $filteredOrders->where('o.status', '=', $request->status); }

        if ($request->filled('start_date') && $request->filled('end_date') ) {
            $start = $request->start_date;
            $end = $request->end_date;

            $filteredOrders->whereBetween('o.created_at', [$start, $end]);

        } else if ($request->filled('start_date')) {

            $filteredOrders->where('o.created_at', '>=', $request->start_date);
            
        } else if($request->filled('end_date')) {

            $filteredOrders->where('o.created_at', '<=', $request->end_date);
        }


        $orders = $filteredOrders->orderBy('o.id', 'DESC')->paginate(25);
        
        return view('orders.index', compact('orders'));
    }

    public function filterProcessedOrders(Request $request) 
    {
        $user = Auth::user();
        $filteredOrders  =  Order::from(Order::alias('o'))
                            ->leftJoin(Customer::alias('c'), 'o.client_id', '=', 'c.id')
                            ->where('receipt_id','=',null)
                            ->where('processed',1)
                            ->select([
                                'o.id', 'o.client_id', 'o.cart_id', 'o.total', 'o.totaliva', 'o.processed',
                                'o.receipt_id','o.created_at','c.name','c.regoldiID','o.status','o.invoice_id'
                            ]);

        if($user->sales_id) { $filteredOrders->where('c.salesman', $user->sales_id);}                    
        
        if ($request->filled('client')) { $filteredOrders->where('c.name', 'like', '%' . $request->client . '%'); }

        if ($request->filled('payment_method')) { $filteredOrders->where('c.payment_method', '=', $request->payment_method); }

        if ($request->filled('status')) { $filteredOrders->where('o.status', '=', $request->status); }

        if ($request->filled('start_date') && $request->filled('end_date') ) {
            $start = $request->start_date;
            $end = $request->end_date;

            $filteredOrders->whereBetween('o.created_at', [$start, $end]);

        } else if ($request->filled('start_date')) {

            $filteredOrders->where('o.created_at', '>=', $request->start_date);
            
        } else if($request->filled('end_date')) {

            $filteredOrders->where('o.created_at', '<=', $request->end_date);
        }

        $orders = $filteredOrders->orderBy('o.id', 'DESC')->get();
        
        return view('orders.processedOrders', compact('orders'));
    }

    public function showProcessedOrders()
    {
        $user = Auth::user();
        if ($user->sales_id == null) {
            $orders = Order::from(Order::alias('o'))
                ->leftJoin(Customer::alias('c'), 'o.client_id', '=', 'c.id')
                ->where('processed',1)
                ->where('receipt_id','=',null)
                ->select([
                    'o.id', 'o.client_id', 'o.cart_id', 'o.total', 'o.totaliva', 'o.processed',
                    'o.receipt_id','o.created_at','c.name','c.regoldiID','o.status','o.invoice_id'
                ])
                ->orderBy('o.id', 'DESC')->get();
        } else {
            $orders = Order::from(Order::alias('o'))
                ->leftJoin(Customer::alias('c'), 'o.client_id', '=', 'c.id')
                ->where('c.salesman', $user->sales_id)
                ->where('receipt_id','=',null)
                ->where('processed',1)
                ->select([
                    'o.id', 'o.client_id', 'o.cart_id', 'o.total', 'o.totaliva', 'o.processed',
                    'o.receipt_id','o.created_at','c.name','c.regoldiID','o.status','o.invoice_id'
                ])
                ->orderBy('o.id', 'DESC')->get();
        }

        foreach($orders as $order)
        {
            $order->receipt = Receipt::where('id',$order->receipt_id)->first()->file ?? null;
            $order->invoice = Receipt::where('id',$order->invoice_id)->first()->file ?? null;
        }

        return view('orders.processedOrders', compact('orders'));
    }

    public function showOrdersByClient($id)
    {
        $user = Auth::user();
        if ($user->sales_id == null) {
            $orders = Order::from(Order::alias('o'))
                ->leftJoin(Customer::alias('c'), 'o.client_id', '=', 'c.id')
                ->where('client_id',$id)
                ->where('status','waiting_payment')
                ->where('receipt_id','=',null)
                ->select([
                    'o.id', 'o.client_id', 'o.cart_id', 'o.total', 'o.totaliva', 'o.processed',
                    'o.receipt_id','o.created_at','c.name','c.regoldiID','o.status','o.invoice_id'
                ])
                ->orderBy('o.id', 'DESC')->get();
        } else {
            $orders = Order::from(Order::alias('o'))
                ->leftJoin(Customer::alias('c'), 'o.client_id', '=', 'c.id')
                ->where('client_id',$id)
                ->where('status','waiting_payment')
                ->where('c.salesman', $user->sales_id)
                ->where('receipt_id','=',null)
                ->select([
                    'o.id', 'o.client_id', 'o.cart_id', 'o.total', 'o.totaliva', 'o.processed',
                    'o.receipt_id','o.created_at','c.name','c.regoldiID','o.status','o.invoice_id'
                ])
                ->orderBy('o.id', 'DESC')->get();
        }

        foreach($orders as $order)
        {
            $order->receipt = Receipt::where('id',$order->receipt_id)->first()->file ?? null;
            $order->invoice = Receipt::where('id',$order->invoice_id)->first()->file ?? null;
        }



        return view('orders.unPaidOrders', compact('orders'));
    }

    public function showHistoryOrders()
    {
        $user = Auth::user();
        if ($user->sales_id == null) {
            $orders = Order::from(Order::alias('o'))
                ->leftJoin(Customer::alias('c'), 'o.client_id', '=', 'c.id')
                ->where('processed',1)
                ->where('receipt_id','!=',null)
                ->where('invoice_id','!=',null)
                ->where('status','paid')
                ->select([
                    'o.id', 'o.client_id', 'o.cart_id', 'o.total', 'o.totaliva', 'o.processed',
                    'o.receipt_id','o.created_at','c.name','c.regoldiID','o.status','o.invoice_id'
                ])
                ->orderBy('o.id', 'DESC')->paginate(30);
        } else {
            $orders = Order::from(Order::alias('o'))
                ->leftJoin(Customer::alias('c'), 'o.client_id', '=', 'c.id')
                ->where('c.salesman', $user->sales_id)
                ->where('receipt_id','=',null)
                ->where('invoice_id','=',null)
                ->where('processed',1)
                ->where('status','paid')
                ->orderBy('o.id', 'DESC')
                ->select([
                    'o.id', 'o.client_id', 'o.cart_id', 'o.total', 'o.totaliva', 'o.processed',
                    'o.receipt_id','o.created_at','c.name','c.regoldiID','o.status','o.invoice_id'
                ])
                ->orderBy('o.id', 'DESC')->paginate(30);
        }

        foreach($orders as $order)
        {
            $order->receipt = Receipt::where('id',$order->receipt_id)->first()->file ?? null;
            $order->invoice = Receipt::where('id',$order->invoice_id)->first()->file ?? null;
        }



        return view('orders.historyOrders', compact('orders'));
    }



    public function viewOrder($id)
    {
        $order = Order::where('id', $id)->first();

        $client = Customer::where('id',$order->client_id)->first();

        if (!isset($order))
            return back();


        $salesPayment = SalesPayment::where('order_id',$id)->first();
        if(isset($salesPayment))
        {
            $salesman = User::where('sales_id',$salesPayment->sales_id)->first();
        }

        $cart = Cart::where('id', $order->cart_id)->first();

        if (isset($cart)) {

            $line_items = OrderLine::where('cart_id', $cart->id)->get();

            foreach ($line_items as $item) {
                $item->product = Product::where('id', $item->product_id)->first();
            }

            $total = OrderLine::where('cart_id', $cart->id)->sum('total');

            return view('orders.order', compact('line_items', 'total', 'order','client','salesman'));
        } else {

            return back();
        }
    }

    public function processOrder($id)
    {
        $order = Order::where('id', $id)->first();
        $user = Auth::user();


        if($order->invoice_id != null)
        {
            $order->processed = 1;
            $order->processed_time = now();     
            $order->save();
        }else{

            $error = "Não é possivel processar esta encomenda";
        }
        $clientUser = User::where('client_id',$order->client_id)->first();

        $message = new Message;

        $message->sender_id = $user->id;
        $message->receiver_id = $clientUser->id;
        $message->text = "A sua encomenda nº".$order->id." foi processada. Obrigado.";
        $message->viewed = 0;

        $message->save();

        if ($user->sales_id == null) {
            $orders = Order::from(Order::alias('o'))
                ->leftJoin(Customer::alias('c'), 'o.client_id', '=', 'c.id')
                ->where('processed',0)
                ->select([
                    'o.id', 'o.client_id', 'o.cart_id', 'o.total', 'o.totaliva', 'o.processed',
                    'o.receipt_id','o.created_at','c.name','c.regoldiID','o.status','o.invoice_id'
                ])
                ->orderBy('o.id', 'DESC')->get();
        } else {
            $orders = Order::from(Order::alias('o'))
                ->leftJoin(Customer::alias('c'), 'o.client_id', '=', 'c.id')
                ->where('c.salesman', $user->sales_id)
                ->where('processed',0)
                ->select([
                    'o.id', 'o.client_id', 'o.cart_id', 'o.total', 'o.totaliva', 'o.processed',
                    'o.receipt_id','o.created_at','c.name','c.regoldiID','o.status','o.invoice_id'
                ])
                ->orderBy('o.id', 'DESC')->get();
        }

        return view('orders.index', compact('orders','error'));
    }

    public function payOrder($id)
    {
        $order = Order::where('id', $id)->first();
        $user = Auth::user();
        $clientUser = User::where('client_id',$order->client_id)->first();

        $order->status = 'paid';

        $order->save();

        $message = new Message;

        $message->sender_id = $user->id;
        $message->receiver_id = $clientUser->id;
        $message->text = "Pagamento da Encomenda nº".$order->id." recebida pelo vendedor ".$user->name.". Obrigado.";
        $message->viewed = 0;

        $message->save();

        $salesPayment = new SalesPayment;

        $salesPayment->sales_id = $user->sales_id;
        $salesPayment->order_id = $order->id;
        $salesPayment->value = number_format(1.23*$order->total,2);
        $salesPayment->delivered = 0;
        $salesPayment->save();


        if ($user->sales_id == null) {
            $orders = Order::from(Order::alias('o'))
                ->leftJoin(Customer::alias('c'), 'o.client_id', '=', 'c.id')
                ->where('processed',0)
                ->select([
                    'o.id', 'o.client_id', 'o.cart_id', 'o.total', 'o.totaliva', 'o.processed',
                    'o.receipt_id','o.created_at','c.name','c.regoldiID','o.status','o.invoice_id'
                ])
                ->orderBy('o.id', 'DESC')->get();
        } else {
            $orders = Order::from(Order::alias('o'))
                ->leftJoin(Customer::alias('c'), 'o.client_id', '=', 'c.id')
                ->where('c.salesman', $user->sales_id)
                ->where('processed',0)
                ->select([
                    'o.id', 'o.client_id', 'o.cart_id', 'o.total', 'o.totaliva', 'o.processed',
                    'o.receipt_id','o.created_at','c.name','c.regoldiID','o.status','o.invoice_id'
                ])
                ->orderBy('o.id', 'DESC')->get();
        }

        return redirect('/processedOrders');
    }

    public function unPayOrder($id)
    {
        $order = Order::where('id', $id)->first();
        $user = Auth::user();
        $clientUser = User::where('client_id',$order->client_id)->first();

        $order->status = 'waiting_payment';

        $order->save();

        $salesPayment = SalesPayment::where('order_id',$id)->first();
        $salesPayment->delete();

        return redirect('/processedOrders');
    }


    public function semiPayOrder(Request $request)
    {
        $inputs = $request->all();
        $order = Order::where('id', $inputs['id'])->first();
        $amount = $inputs['amount'];
        $user = Auth::user();


        $order->total -= $amount;
        $order->save();

        $neworder = New Order;
        $neworder->total = $amount;
        $neworder->client_id = $order->client_id;
        $neworder->status = 'paid';
        $neworder->cart_id = $order->cart_id;
        $neworder->processed = 1;
        $neworder->save();

        $salesPayment = new SalesPayment;

        $salesPayment->sales_id = $user->sales_id;
        $salesPayment->order_id = $order->id;
        $salesPayment->value = number_format($amount,2);
        $salesPayment->delivered = 0;
        $salesPayment->save();

        if ($user->sales_id == null) {
            $orders = Order::from(Order::alias('o'))
                ->leftJoin(Customer::alias('c'), 'o.client_id', '=', 'c.id')
                ->where('processed',0)
                ->select([
                    'o.id', 'o.client_id', 'o.cart_id', 'o.total', 'o.totaliva', 'o.processed',
                    'o.receipt_id','o.created_at','c.name','c.regoldiID','o.status','o.invoice_id'
                ])
                ->orderBy('o.id', 'DESC')->get();
        } else {
            $orders = Order::from(Order::alias('o'))
                ->leftJoin(Customer::alias('c'), 'o.client_id', '=', 'c.id')
                ->where('c.salesman', $user->sales_id)
                ->where('processed',0)
                ->select([
                    'o.id', 'o.client_id', 'o.cart_id', 'o.total', 'o.totaliva', 'o.processed',
                    'o.receipt_id','o.created_at','c.name','c.regoldiID','o.status','o.invoice_id'
                ])
                ->orderBy('o.id', 'DESC')->get();
        }

        return redirect('/processedOrders');
    }

    public function printOrder($id, $type = 'single')
    {
        $order = Order::where('id', $id)
        ->select([
            'client_id', 'cart_id', 'created_at'
        ])
        ->first();

        $client = Customer::where('id',$order->client_id)
        ->select([
            'name', 'address', 'regoldiID'
        ])
        ->first();

        $cart = Cart::where('id', $order->cart_id)->first();

        if (isset($cart)) {

            $line_items = OrderLine::where('cart_id', $cart->id)->get();

            foreach ($line_items as $item) {
                $item->product = Product::where('id', $item->product_id)->first();
            }

            if($type === 'single') {
                return view('orders.print', compact('line_items', 'order', 'client'));
            } else if ($type === 'multiple') {
                return ['line_items' => $line_items, 'order' => $order , 'client' => $client];
            }

        } else {
            return back();
        }
    }

    public function printOrders(Request $request)
    {
        $printArray = explode(',', $request->printOrders[0]);
        $printingData = [];

        foreach ($printArray as $id) {
            array_push($printingData, $this->printOrder($id, 'multiple'));
        }

        return view('orders.printAll', compact('printingData'));
    }

    public function messages($id)
    {
        $user = Auth::user();

        if($user->sales_id == null and $user->client_id == null and $id == $user->id)
        {

            return view('messages.massmessage');
        }

        if ($user->sales_id != null and $user->id != $id) {
            return back();
        }
        $messages = Message::where('receiver_id', $id)->get();

        $receiver = User::where('id', $id)->first();

        return view('messages.messages', compact('messages', 'id', 'receiver'));
    }

    public function newMessage(Request $request)
    {
        $user = Auth::user();
        $inputs = $request->all();
        $text = $inputs['message'];


        $message = new Message;

        $message->sender_id = $user->id;
        $message->receiver_id = $inputs['id'];
        $message->text = $inputs['message'];
        $message->viewed = 0;

        $message->save();


        Mail::send('emails.welcome', compact('user', 'text'),
            function ($m) use ($user) {
                /** @var \Illuminate\Mail\Message $m */
                $m->from('suporte@regolfood.pt', 'Mensagem Regolfood');
                $m->to($user->email, '', true);
                $m->subject('Mensagem Regolfood');
            });

        return back();

    }

    public function newMassMessage(Request $request)
    {
        $user = Auth::user();
        $inputs = $request->all();
        $text = $inputs['message'];
        $target = $inputs['target'];

        if($target = 'clients') {
            $clients = User::where('client_id', '!=', null)->get();

            foreach ($clients as $client) {
                $message = new Message;

                $message->sender_id = $user->id;
                $message->receiver_id = $client->id;
                $message->text = $inputs['message'];
                $message->viewed = 0;
                $message->save();
            }
        }elseif($target = 'sales') {

            $clients = User::where('sales_id', '!=', null)->get();

            foreach ($clients as $client) {
                $message = new Message;

                $message->sender_id = $user->id;
                $message->receiver_id = $client->id;
                $message->text = $inputs['message'];
                $message->viewed = 0;
                $message->save();
            }
        }
        return back();
    }


    public function attachReceipt(Request $request)
    {
        $inputs = $request->all();

        $request->validate([
            'receipt' => 'required',
        ],[
            'receipt.required' => 'Por favor associe um ficheiro.'
        ]);

        $order = Order::where('id',$inputs['order'])->first();
        $user = Auth::user();

        if($request->hasfile('receipt'))
        {
            $receipt = new Receipt;

            $receipt->client_id = $order->client_id;
            $receipt->name = date('Y-m-d');
            $receipt->document_type_id = 2;
            $receipt->viewed = 0;

            $file = $request->file('receipt');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = $file->getClientOriginalName().'.'.$extension;
            $file->move('uploads/'.$order->client_id.'/', $filename);


            //TODO Envio de email

            $receipt->file = $filename;
            $receipt->save();
        }

        $clientUser = User::where('client_id',$order->client_id)->first();

        $message = new Message;

        $message->sender_id = $user->id;
        $message->receiver_id = $clientUser->id;
        $message->text = "Foi adicionado o recibo à sua encomenda nº".$order->id." . Obrigado.";
        $message->viewed = 0;

        $message->save();

        $order->receipt_id = $receipt->id;
        $order->save();

        return back();


    }

    public function attachInvoice(Request $request)
    {
        $inputs = $request->all();

        $request->validate([
            'receipt' => 'required',
        ],[
            'receipt.required' => 'Por favor associe um ficheiro.'
        ]);

        $order = Order::where('id',$inputs['order'])->first();

        if($request->hasfile('receipt'))
        {
            $receipt = new Receipt;

            $receipt->client_id = $order->client_id;
            $receipt->name = date('Y-m-d');
            $receipt->document_type_id = 3;
            $receipt->viewed = 0;

            $file = $request->file('receipt');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = $file->getClientOriginalName().'.'.$extension;
            $file->move('uploads/'.$order->client_id.'/', $filename);


            //TODO Envio de email

            $receipt->file = $filename;
            $receipt->save();
        }

        $order->invoice_id = $receipt->id;
        $order->save();

        return redirect('/orders');


    }
}
