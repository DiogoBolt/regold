<?php

namespace App\Http\Controllers;

use App\Customer;
use App\DocumentType;
use App\Group;
use App\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        if($user)
        {
            if($user->client_id != null) {
                $client = Customer::where('id', $user->client_id)->first();
                $group = Group::where('id',$client->group_id)->first();
                $types = DocumentType::all();

                $receipts = Receipt::where('client_id',$client->id)->get();
                return view('frontoffice.show', compact('client','group','types','receipts'));
            }else{
                return redirect('/clients');
            }
        }


        return view('home');
    }
}
