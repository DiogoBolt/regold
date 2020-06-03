<?php

namespace App\Http\Controllers;

use App\Customer;
use App\DocumentType;
use App\Group;
use App\Receipt;
use App\Thermo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

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


        return redirect('/login');
    }

    public function duvidascovid()
    {
        return view('frontoffice.covid');

    }
    public function receiveThermo(Request $request)
    {
        $inputs = $request->all();

        $thermo = new Thermo;

        $thermo->client_id = 0;
        $thermo->thermo_type ="Teste";
        $thermo->temperature = $inputs['temperature'];
        $thermo->imei = $inputs['imei'];
        $thermo->last_read = Carbon::now();

        $thermo->save();


        return 200;
    }

}
