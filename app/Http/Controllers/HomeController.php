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
                return redirect('/home');
            }else{
                return redirect('/clients');
            }
        }


        return view('home');
    }
}
