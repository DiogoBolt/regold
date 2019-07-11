<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Category;
use App\Client;
use App\DocumentSuperType;
use App\DocumentType;
use App\Group;
use App\Message;
use App\Order;
use App\OrderLine;
use App\Product;
use App\Receipt;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

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

    public function showClient()
    {
        $user = Auth::user();
        $client = Client::where('id',$user->client_id)->first();

        $group = Group::where('id',$client->group_id)->first();
        return view('frontoffice.show',compact('client','group'));
    }

    public function editClient()
    {
        $user = Auth::user();
        $client = Client::where('id',$user->client_id)->first();
        return view('frontoffice.edit',compact('client'));
    }

    public function postEditClient(Request $request)
    {

        $inputs = $request->all();
        $client = Client::where('id',$inputs['id'])->first();

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
        $client = Client::where('id',$user->client_id)->first();

        $group = Group::where('id',$client->group_id)->first();
        $types = DocumentType::all();

        $receipts = Receipt::where('client_id',$client->id)->get();

        return view('frontoffice.documents',compact('client','receipts','group','types'));
    }


    public function documentsByType($type)
    {
        $user = Auth::user();
        $client = Client::where('id',$user->client_id)->first();


        $receipts = Receipt::from(Receipt::alias('r'))
            ->leftJoin(DocumentType::alias('dt'), 'r.document_type_id', '=', 'dt.id')
            ->leftJoin(DocumentSuperType::alias('dst'), 'dt.superType', '=', 'dst.id')
            ->where('dst.name',$type)
            ->where('r.client_id',$client->id)
            ->get();


        return view('frontoffice.documentsType',compact('receipts','client','type'));
    }

    public function products()
    {
        $products = Product::all();


        return view('frontoffice.products',compact('products','categories'));
    }

    public function addCart(Request $request)
    {
        $inputs = $request->all();

        $user = Auth::user();
        $cart = Cart::where('user_id',$user->id)->where('processed',0)->first();

        if(!isset($cart))
        {
            $cart = new Cart;
            $cart->user_id = $user->id;
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

        if($order_line->amount >= $product->amount3)
        {
            $order_line->total = $product->price3 * $order_line->amount;
        }elseif($order_line->amount >= $product->amount2)
        {
            $order_line->total = $product->price2 * $order_line->amount;
        }else{

            $order_line->total = $product->price1 * $order_line->amount;
        }


        $order_line->save();

        $line_items = OrderLine::where('cart_id',$cart->id)->get();

        foreach($line_items as $item)
        {
            $item->name = Product::where('id',$item->product_id)->first()->name;
        }

        $total = OrderLine::where('cart_id',$cart->id)->sum('total');



        return redirect('/frontoffice/cart');

    }


    public function showCart()
    {
        $user = Auth::user();

        $cart = Cart::where('user_id',$user->id)->where('processed',0)->first();

        if(!isset($cart))
        {
            $cart = new Cart;
            $cart->user_id = $user->id;
            $cart->save();
        }

        $line_items = OrderLine::where('cart_id',$cart->id)->get();

        foreach($line_items as $item)
        {
            $item->product = Product::where('id',$item->product_id)->first();
        }

        $total = OrderLine::where('cart_id',$cart->id)->sum('total');



        return view('frontoffice.cart',compact('line_items','total'));

    }

    public function cartValue()
    {
        $user = Auth::user();

        $cart = Cart::where('user_id',$user->id)->where('processed',0)->first();

        if(!isset($cart))
        {
            $cart = new Cart;
            $cart->user_id = $user->id;
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


    public function processCart()
    {
        $user = Auth::user();

        $cart = Cart::where('user_id',$user->id)->where('processed',0)->first();

        if(!isset($cart))
        {
            $products = Product::all();

            return view('frontoffice.products',compact('products'));
        }

        $total = OrderLine::where('cart_id',$cart->id)->sum('total');

        $totaliva = $total + 0.23*$total;

        $order = new Order;

        $order->client_id = $user->client_id;
        $order->cart_id = $cart->id;
        $order->total = $total;
        $order->totaliva = $totaliva;
        $order->processed = 0;

        $order->save();
        $cart->processed = 1;
        $cart->save();

        $orders = Order::where('client_id',$user->client_id)->get();

        return view('frontoffice.orders',compact('orders'));

    }

    public function orders()
    {
        $user = Auth::user();
        $orders = Order::where('client_id',$user->client_id)->get();

        return view('frontoffice.orders',compact('orders'));
    }


    public function viewOrder($id)
    {
        $user = Auth::user();

        $order = Order::where('id',$id)->where('client_id',$user->client_id)->first();

        if(!isset($order))
        return back();

       $cart = Cart::where('user_id',$user->id)->where('id',$order->cart_id)->first();

        if(isset($cart))
        {
            $line_items = OrderLine::where('cart_id',$cart->id)->get();

            foreach($line_items as $item)
            {
                $item->product = Product::where('id',$item->product_id)->first();
            }

            $total = OrderLine::where('cart_id',$cart->id)->sum('total');

            return view('frontoffice.order',compact('line_items','total','order'));
        }else {

            return back();
        }
    }

    public function productsByCategory($name)
    {
        $products = Product::where('category',$name)->get();


        return view('frontoffice.products',compact('products'));
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


    public function messages()
    {
        $user = Auth::user();
        $messages = Message::where('receiver_id',$user->id)->get();

        foreach($messages as $message)
        {
            $message->viewed = 1;
            $message->save();
        }

        return view('frontoffice.messages',compact('messages'));
    }
}
