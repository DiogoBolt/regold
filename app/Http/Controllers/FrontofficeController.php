<?php

namespace App\Http\Controllers;

use App\Callback;
use App\Cart;
use App\Category;
use App\ClientProduct;
use App\Customer;
use App\DocumentSuperType;
use App\DocumentType;
use App\Favorite;
use App\Group;
use App\Message;
use App\NewProductRecords;
use App\OilRecord;
use App\Order;
use App\OrderLine;
use App\Product;
use App\Receipt;
use App\User;
use App\Section;
use App\ControlCustomizationClients;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class FrontofficeController extends Controller
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

    public function showCustomer()
    {
        $user=Auth::user();

        $user = User::where('id',$user->id)
        ->first();

        $client = Customer::where('id',$user->client_id)->first();

        return view('frontoffice.show',compact('user','client'));
    }
    public function saveEditClient(Request $request)
    {
        $user=Auth::user();
        $inputs=$request->all();

        $client=Customer::where('id',$inputs['id'])->first();

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

        return view('frontoffice.show',compact('client','user'));

    }

    public function editClient($id)
    {
        $client = Customer::where('id',$id)->first();
        return view('frontoffice.edit',compact('client'));
    }


    public function postEditClient(Request $request)
    {
        $inputs = $request->all();
        $client = Customer::where('id',$inputs['id'])->first();

        $client->address = $inputs['address'];
        $client->city = $inputs['city'];
        $client->nif = $inputs['nif'];
        $client->email = $inputs['email'];
        $client->activity = $inputs['activity'];
        $client->telephone = $inputs['telephone'];
        $client->receipt_email = $inputs['receipt_email'];
        $client->nib = $inputs['nib'];

        $client->save();

        return view('frontoffice.edit',compact('client'));
    }

    public function documents()
    {
        $user = Auth::user();

        $types = DocumentType::all();

        $clients = Customer::where('ownerID',$user->id)
        ->select([
            'id'
            ,])
        ->get();

        $ids = [];
        
        foreach($clients as $client){
            array_push($ids,$client->id);
        }

        $receipts=Receipt::whereIN('client_id',$ids)->get();

        return view('frontoffice.documents',compact('client','receipts','types'));
    }

    public function invoices()
    {
        $user = Auth::user();
        $client = Customer::where('id',$user->client_id)->first();

        $paidInvoices = $this->paidInvoices();
        $unpaidInvoices = $this->unpaidInvoices();

        $totalUnpaidAmount = Order::where('client_id',$client->id)->where('invoice_id','!=',null)->where('status','waiting_payment')->sum('total');

        return view('frontoffice.invoices', compact('paidInvoices', 'unpaidInvoices', 'totalUnpaidAmount'));
    }

    public function paidInvoices()
    {
        $user = Auth::user();
        $client = Customer::where('id',$user->client_id)->first();

        $receipts = Receipt::from(Receipt::alias('r'))
            ->leftJoin(Order::alias('o'), 'o.invoice_id', '=', 'r.id')
            ->where('o.client_id',$client->id)
            ->where('status','paid')
            ->paginate(10);

        return $receipts;
    }

    public function unpaidInvoices()
    {
        $user = Auth::user();
        $client = Customer::where('id',$user->client_id)->first();

       $receipts = Receipt::from(Receipt::alias('r'))
            ->leftJoin(Order::alias('o'), 'o.invoice_id', '=', 'r.id')
           ->where('o.client_id',$client->id)
            ->where('status','waiting_payment')
            ->paginate(10);

        return $receipts;
    }

    public function documentsByType($super, $type,Request $request)
    {
        $user = Auth::user();

        $auxClientId = Session::get('establismentID');

        if($type==26)
        {
            return redirect('/frontoffice/records/temperatures');

        }

        $clients = Customer::where('id',$auxClientId)
        ->select([
            'id'
            ,])
        ->get();

        $ids = [];
        
        foreach($clients as $client){
            array_push($ids,$client->id);
        }


            $receipts = Receipt::from(Receipt::alias('r'))
                ->leftJoin(DocumentType::alias('dt'), 'r.document_type_id', '=', 'dt.id')
                ->leftJoin(DocumentSuperType::alias('dst'), 'dt.superType', '=', 'dst.id')
                ->groupBy('r.id')
                ->where('dst.name', $super)
                ->whereIN('r.client_id',$ids)
                ->where('dt.id', $type )
                ->get(['r.id']);
            $ids = [];


            foreach($receipts as $receipt)
            {
                $updated = Receipt::where('id',$receipt->id)->first();
                $updated->viewed = 1;
                $updated->save();
                array_push($ids,$receipt->id);
            }

            $receipts = Receipt::whereIN('id',$ids)->get();


        return view('frontoffice.documentsType',compact('receipts','client','type', 'super'));

    }

    public function documentsBySuper($super)
    {

        $auxClientId = Session::has('clientImpersonatedId') ? Session::get('clientImpersonatedId') : Session::get('establismentID');

        $clientPermission=Customer::where('id',$auxClientId)
            ->first();

        $auxAdminId=Session::get('impersonated');

        $clientActivity = Customer::where('id',$auxClientId)
        ->select(['activity',])
        ->pluck('activity')
        ->first();

       $controlCustomizationClient=ControlCustomizationClients::where('idClient',$auxClientId)
       ->select(['personalizeSections'])
       ->pluck('personalizeSections')->first();

       $controlFirstServiceClient=ControlCustomizationClients::where('idClient',$auxClientId)
           ->select(['firstServicePest'])
           ->pluck('firstServicePest')->first();

       if($auxAdminId==null)
       {
           /*$abc=Customer::where('id',$auxClientId)
               ->select(['ownerID'])
               ->pluck('ownerID')
               ->first();*/
           $userType=4;
       }else{
           $userType=User::where('id',$auxAdminId)
               ->select(['userType'])
               ->pluck('userType')->first();
       }

        $qtd = Section::where('activityClientId',$clientActivity)->count();

        if($qtd > 1){
            $showSections=1;
        }else{
            $showSections=0;
        }

        $superId = DocumentSuperType::where('name', $super)->pluck('id');
        
        $types = DocumentType::where('superType', $superId)->get();

        return view('frontoffice.documentsTypes',compact('types','userType','super','showSections','controlCustomizationClient','controlFirstServiceClient','clientPermission'));
    }

    public function products()
    {
        $products = Product::all();

        return view('frontoffice.products',compact('products','categories'));
    }

    public function productsSearch($search_term) {

        $search_result = Product::select(['id', 'name', 'file', 'category'])
        ->where('name', 'like', '%' . $search_term . '%')
        ->get();

        return $search_result;
    }

    public function categories()
    {
        $categories = Category::all();

        return view('frontoffice.categories',compact('categories'));
    }

    public function addCart(Request $request)
    {
        $inputs = $request->all();


        $auxClientId = Session::get('establismentID');

        $cart = Cart::where('client_id',$auxClientId)->where('processed',0)->first();

        if(!isset($cart))
        {
            $cart = new Cart;
            $cart->client_id = $auxClientId;
            $cart->save();
        }

        $order_line = OrderLine::where('product_id',$inputs['id'])->where('cart_id',$cart->id)->first();

        if(!isset($order_line))
        {
            $order_line = new OrderLine;
            $order_line->product_id = $inputs['id'];
            $order_line->cart_id = $cart->id;
            $order_line->amount = $inputs['amount'];
        }else{
            $order_line->amount += $inputs['amount'];
        }

        $product = Product::where('id',$order_line->product_id)->first();

        $pvp = ClientProduct::where('client_id',$auxClientId)->where('product_id',$product->id)->first()->pvp;


        switch ($pvp) {
            case 1:
                $order_line->total = $product->price1 * $order_line->amount;
                break;
            case 2:
                $order_line->total = $product->price2 * $order_line->amount;
                break;
            case 3:
                $order_line->total = $product->price3 * $order_line->amount;
                break;
            case 4:
                $order_line->total = $product->price4 * $order_line->amount;
                break;
            case 5:
                $order_line->total = $product->price5 * $order_line->amount;
                break;
        }
        $order_line->save();

        $order_lines = OrderLine::where('cart_id',$cart->id)->get();

       /* foreach($order_lines as $order)
        {
            $product = Product::where('id',$order->product_id)->first();
            if($pvp == 3)
            {
                $order->total = $product->price3 * $order->amount;
            }elseif($pvp = 2)
            {
                $order->total = $product->price2 * $order->amount;
            }else{
                $order->total = $product->price1 * $order->amount;
            }
            $order->save();
        }*/

        $line_items = OrderLine::where('cart_id',$cart->id)->get();

        foreach($line_items as $item)
        {
            $item->name = Product::where('id',$item->product_id)->first()->name;
        }

        $total = OrderLine::where('cart_id',$cart->id)->sum('total');

        return back();
    }

    public function cartValue()
    {
        $user = Auth::user();
        $auxClientId = Session::get('establismentID');
        $cart = Cart::where('client_id',$auxClientId)->where('processed',0)->first();

        if(!isset($cart))
        {
            $cart = new Cart;
            $cart->client_id = $auxClientId;
            $cart->save();
        }

        $line_items = OrderLine::where('cart_id',$cart->id)->get();

        foreach($line_items as $item)
        {
            $item->product = Product::where('id',$item->product_id)->first();
        }

        $total = OrderLine::where('cart_id',$cart->id)->sum('total');

        return $total;
    }

    public function orders()
    {
        $user = Auth::user();
        $auxClientId = Session::get('establismentID');

        $orders = Order::where('client_id',$auxClientId)->orderBy('id','DESC')->get();

        return view('frontoffice.orders',compact('orders'));
    }

    public function viewOrder($id)
    {
        $user = Auth::user();


        $order = Order::where('id',$id)->where('client_id',Session::get('establismentID'))->first();

        if(!isset($order))
        return back();

       $cart = Cart::where('client_id',Session::get('establismentID'))->where('id',$order->cart_id)->first();

        if(isset($cart))
        {
            $line_items = OrderLine::where('cart_id',$cart->id)->get();

            foreach($line_items as $item)
            {
                $item->product = Product::where('id',$item->product_id)->first();
            }

            $total = OrderLine::where('cart_id',$cart->id)->sum('total');

            if($order->total>29.90){
                $extra = $order->total - $total;
            }else{
                $extra = 5;
            }

            return view('frontoffice.order',compact('line_items','extra','total','order'));
        }else {

            return back();
        }
    }

    public function productsByCategory($id)
    {
        $user = Auth::user();
        $products = Product::where('category',$id)->orderby('name')->get();

        foreach($products as $product)
        {
            $pvp = ClientProduct::where('client_id',Session::get('establismentID'))->where('product_id',$product->id)->first();

            if(isset($pvp))
            {
                $product->pvp = $pvp->pvp;
            }else{
                $product->pvp = 1;
            }

        }

        return view('frontoffice.products',compact('products'));
    }

    public function productById($id)
    {
        $user = Auth::user();
        $pvp = ClientProduct::where('client_id',Session::get('establismentID'))->where('product_id',$id)->first()->pvp;

        $product = Product::where('id', $id)->first();
        $isFavourite = Favorite::where('product_id', $id)->where('user_id', Session::get('establismentID'))->first();

        return view('frontoffice.product',compact('product', 'isFavourite','pvp'));
    }

    public function deleteLineFromCart($id)
    {
        $user = Auth::user();

        $order_line = OrderLine::where('id',$id)->first();

        $cart = Cart::where('id',$order_line->cart_id)->first();

        if($cart->user_id != $user->id || $cart->processed == 1)
        return back();

        $order_line->delete();

        return back();
    }

    public function removeItem(Request $request)
    { 
        $user = Auth::user();
        $inputs = $request->all();
        
        $auxClientId = Session::get('establismentID');
        
        $order_line = OrderLine::where('id',$inputs['id'])->first();

        $cart = Cart::where('id',$order_line->cart_id)->first();

        if($cart->client_id != $auxClientId || $cart->processed == 1){
            return back();
        }

        if($inputs['qt'] == $order_line->amount)
        {
            $order_line->delete();

        }else{
            $aux=$order_line->amount-$inputs['qt'];

            $auxTotal= $aux*$order_line->total;
            $auxTotalFinal=$auxTotal/$order_line->amount;
            
            $order_line->amount =$aux;
            $order_line->total = $auxTotalFinal;
            
            $order_line->save();
        }
        //return back();
    }

    function messages()
    {
        $user = Auth::user();

        $messages = Message::where('receiver_id',$user->client_id)
            ->where('viewed',0)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontoffice.messages',compact('messages','user'));
    }
    function filterMessages($type){

        $user = Auth::user();

        if($type == 1){
            $messages = Message::where('receiver_id',$user->client_id)
                ->orderBy('created_at', 'desc')
                ->get();
        }elseif($type == 2){
            $messages = Message::where('receiver_id',$user->client_id)
                ->where('viewed',0)
                ->orderBy('created_at', 'desc')
                ->get();
        }elseif($type == 3){
            $messages = Message::where('receiver_id',$user->client_id)
                ->where('type',$type)
                ->orderBy('created_at', 'desc')
                ->get();
        }elseif ($type == 4)
        {
            $messages = Message::where('receiver_id',$user->client_id)
                ->where('type',$type)
                ->orderBy('created_at', 'desc')
                ->get();
        }else{
            $messages = Message::where('receiver_id',$user->client_id)
                ->where('type',$type)
                ->orderBy('created_at', 'desc')
                ->get();
        }

       return $messages;
    }

    function readMessage($id){

        $message=Message::where('id',$id)->first();
        $message->viewed=1;
        $message->save();
    }
    function allreads($id){

        $messages=Message::where('receiver_id',$id)
            ->where('viewed',0)
            ->get();

        foreach ($messages as $message){
            $message->viewed=1;
            $message->save();
        }

        return back();
    }

    public function processCart(Request $request)
    {
        $inputs = $request->all();

        $user = Auth::user();

        $auxClientId = Session::get('establismentID');

        $client = Customer::where('id',$auxClientId)->first();
        $cart = Cart::where('client_id',$auxClientId)->where('processed',0)->first();

        $orders = Order::where('client_id',$auxClientId)
        ->where('processed',1)
        ->where('created_at','>=',Carbon::now()->startOfMonth())->count();

        if(!isset($cart))
        {
            $products = Product::all();

            return view('frontoffice.products',compact('products'));
        }

        $total = OrderLine::where('cart_id',$cart->id)->sum('total');

        $iva = 0;

        $items = OrderLine::where('cart_id',$cart->id)->get();

        foreach($items as $item)
        {
            $product = Product::where('id',$item->product_id)->first();
            $iva+=$product->IVA/100*$item->total;
        }


        /*$order = Order::where('client_id',$auxClientId)->where('status','waiting_payment')
        ->where('invoice_id',null)->first();
        */

        $order = new Order;
        $order->client_id = $auxClientId;
        $order->cart_id = $cart->id;
        $order->total = $total;
        $order->totaliva =  $iva;
        $order->processed = 0;
        $order->status = 'waiting_payment';
        $order->external_id = uniqid();
        $order->note = $inputs['order_note'];
        $order->save();

        $total = $order->total;
        $cart->processed = 1;

        $cart->save();

        if($orders > 0) {
            if ($total < 29.90) {
                $order->total += 5;
                $order->save();
            }
        } else {
                if ($total < $client->contract_value) {
                    $order->total = $client->contract_value;
                    $order->totaliva = $client->contract_value * 0.23;
                    $order->save();
                }
            }

            switch ($client->payment_method) {
                case "Debito Direto":
                    $message = new Message();
                    $day = Date('d');
                    if ($day < 16) {
                        $message->text = "O pagamento da compra nº" . $order->id . " do estabelecimento " . $client->name . " será efetuado no dia 15 do próximo mês";
                    } else {
                        $message->text = "O pagamento da compra nº" . $order->id . " do estabelecimento " . $client->name . " será efetuado no dia 30 do próximo mês";
                    }
                    $message->sender_id = 1;
                    $message->receiver_id = $user->client_id;
                    $message->viewed = 0;
                    $message->type = 5;
                    $message->save();
                    $order->total = $total;
                    $order->save();
                    return redirect('/frontoffice/orders');
                    break;
                case "Contra Entrega":
                    $order->total = $total;
                    $order->save();
                    $response = $this->processPayment($cart, $order);
                    return redirect($response->url_redirect);
                    break;
                case "Fatura Contra Fatura":
                    $order->total = $total;
                    $order->save();
                    $response = $this->processPayment($cart, $order);
                    return redirect($response->url_redirect);
                    break;
                case "30 dias":
                    $response = $this->processPayment($cart, $order);
                    return redirect($response->url_redirect);
                    break;
                case "Tranferência/30dias":
                    $response = $this->processPayment($cart, $order);
                    return redirect($response->url_redirect);
                    break;
            }
        return back();
    }

    public function showCart()
    {
        $user = Auth::user();

        $auxClientId = Session::get('establismentID');

        $client = Customer::where('id',$auxClientId)->first();

        $orders = Order::where('client_id',$auxClientId)
        ->where('processed',1)
        ->where('created_at','>=',Carbon::now()->startOfMonth())->count();

        $cart = Cart::where('client_id',$auxClientId)->where('processed',0)->first();

        $items =[];

        if(!isset($cart))
        {
            $cart = new Cart;
            $cart->client_id = $auxClientId;
            $cart->save();
        }

        $line_items = OrderLine::where('cart_id',$cart->id)->get();
        $ivatotal = 0;
        $total = 0;

        foreach($line_items as $item)
        {
            $item->product = Product::where('id',$item->product_id)->first();
            $ivatotal += $item->product->IVA / 100 * $item->total;
        }

        $total = OrderLine::where('cart_id',$cart->id)->sum('total');
        $totalprod = OrderLine::where('cart_id',$cart->id)->sum('total');

        if($orders > 0)
        {
           if($total < 29.90)
           {
               $servico = [];
               $servico['qt'] = 1;
               $servico['descr'] = "Portes";
               $servico['amount'] = 5;
               array_push($items,$servico);
               $total += $servico['amount'];
               $ivatotal += $servico['amount'] * 0.23;
           }

        }else{
            if($total < $client->contract_value)
            {
                $servico = [];
                $servico['qt'] = 1;
                $servico['descr'] = "Serviço HACCP";
                $servico['name'] = "Serviço HACCP";
                $servico['amount'] = $client->contract_value - $total;
                $ivatotal += $servico['amount'] * 0.23;
                array_push($items,$servico);
                $total += $servico['amount'];
            }

        }

        $iva = [];
        $iva['qt'] = 1;
        $iva['descr'] = "Iva";
        $iva['name'] = "Iva";
        $iva['amount'] = number_format($ivatotal,2);
        $total += $iva['amount'];
        array_push($items,$iva);

        return view('frontoffice.cart',compact('line_items','total','items','totalprod'));
    }

    private function processPayment($cart,$order)
    {
        $user = Auth::user();

        $auxClientId = Session::get('establismentID');

        $orders = Order::where('client_id',$auxClientId)->where('id','!=',$order->id)->where('processed',1)
        ->where('created_at','>=',Carbon::now()->startOfMonth())->count();

        if($orders > 0)
        {
           return $this->processSideOrder($cart,$order);
        }else{
           return $this->processMainOrder($cart,$order);
        }
    }

    private function processSideOrder($cart,$order)
    {
        $user = Auth::user();

        $auxClientId =Session::get('establismentID');

        $orderlines = OrderLine::where('cart_id',$cart->id)->get();
        $client = Customer::where('id',$auxClientId)->first();
        $customer = Customer::where('id',$auxClientId)->first();

        $items =[];
        foreach($orderlines as $orderline)
        {
            $product = Product::where('id',$orderline->product_id)->first();
            $item = [];
            $item['descr'] = $product->name;
            $item['name'] = $product->name;
            $item['qt'] = $orderline->amount;
            $item['amount'] = number_format($orderline->total,2);

            array_push($items,$item);
        }

        $options = [
            'cost' => 10,
        ];

        if($order->total < 29.90)
        {
            $servico = [];
            $servico['qt'] = 1;
            $servico['descr'] = "Portes";
            $servico['name'] = "Portes";
            $servico['amount'] = 5;

            array_push($items,$servico);
        }

        $iva = [];
        $iva['qt'] = 1;
        $iva['descr'] = "Iva";
        $iva['name'] = "Iva";
        $iva['amount'] = number_format($order->totaliva,2);

        array_push($items,$iva);


        $payment = [
            'client' => ['address' => ['address' => $customer->address,'city'=>$customer->city,'country'=>'PT'], 'email' => $customer->email,'name' => $customer->name],
            'amount' => number_format($order->total > 29.90 ? $order->total + $order->totaliva : $order->total + $order->totaliva + 5,2),
            'currency' => 'EUR',
            'items' =>$items,
            'ext_invoiceid' => $order->external_id,
            'ext_costumerid' => $order->user_id,
        ];

        $request_data = [
            'payment' => $payment,
            'required_fields' => [
//                'name' => true,
//                'email' => true,
//                'nif' => true,
            ],
            'url_cancel' => 'http://www.regolfood.pt',
            'url_confirm' => 'http://www.regolfood.pt',
        ];

        $url = 'https://services.wallet.pt/api/v2/checkout';

        $response = $this->http($url, $request_data);

        return $response;
    }

    private function processMainOrder($cart,$order)
    {
        $user = Auth::user();
        $auxClientId = Session::get('establismentID');

        $orderlines = OrderLine::where('cart_id',$cart->id)->get();
        $total = OrderLine::where('cart_id',$cart->id)->sum('total');
        $client = Customer::where('id',$auxClientId)->first();
        $customer = Customer::where('id',$auxClientId)->first();

        $items =[];
        foreach($orderlines as $orderline)
        {
            $product = Product::where('id',$orderline->product_id)->first();
            $item = [];
            $item['descr'] = $product->name;
            $item['name'] = $product->name;
            $item['qt'] = $orderline->amount;
            $item['amount'] = number_format($orderline->total,2);

            array_push($items,$item);
        }

        $options = [
            'cost' => 10,
        ];

        if($total < $client->contract_value)
        {
            $servico = [];
            $servico['qt'] = 1;
            $servico['descr'] = "Serviço HACCP";
            $servico['name'] = "Serviço HACCP";
            $servico['amount'] = number_format($client->contract_value - $total,2);
            array_push($items,$servico);
        }

        $iva = [];
        $iva['qt'] = 1;
        $iva['descr'] = "Iva";
        $iva['name'] = "Iva";
        $iva['amount'] = number_format($order->totaliva,2);


        array_push($items,$iva);

        $payment = [
            'client' => ['address' => ['address' => $customer->address,'city'=>$customer->city,'country'=>'PT'], 'email' => $customer->email,'name' => $customer->name],
            'amount' => number_format($order->total + $order->totaliva,2),
            'currency' => 'EUR',
            'items' =>$items,
            'ext_invoiceid' => $order->external_id,
            'ext_costumerid' => $order->user_id,
        ];

        $request_data = [
            'payment' => $payment,
            'required_fields' => [
//                'name' => true,
//                'email' => true,
//                'nif' => true,
            ],
            'url_cancel' => 'http://www.regolfood.pt',
            'url_confirm' => 'http://www.regolfood.pt',
        ];

        $url = 'https://services.wallet.pt/api/v2/checkout';

        $response = $this->http($url, $request_data);

        return $response;
    }

    private function http($url, $data = null, $method = null){

        $authToken    = 'e5e46b4e88f5b8deb29d4bbfb754cdd90cf8324f';
        $headers      = [
            'Authorization: WalletPT ' . $authToken,
            'Content-Type: application/json'
        ];
        if ($method === null) {
            $method = $data === null ? 'GET' : 'POST';
        }
        $request_data = null;
        if ($data !== null) {
            $request_data = json_encode($data);
            $headers[] = 'Content-Length: ' . strlen($request_data);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($request_data !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request_data);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        if (env('CURL_PROXY', false)) {
            curl_setopt($ch, CURLOPT_PROXY, env('CURL_PROXY'));
        }
        $response = curl_exec($ch);

        return json_decode($response);
    }

}