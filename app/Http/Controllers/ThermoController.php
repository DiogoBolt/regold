<?php

namespace App\Http\Controllers;


use App\ClientThermo;
use App\Thermo;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class ThermoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function index()
    {
        $user = Auth::user();

        $thermos = Thermo::from(Thermo::alias('t'))
            ->leftJoin(ClientThermo::alias('ct'), 't.id', '=', 'ct.thermo_id')
            ->where('ct.user_id',$user->id)
            ->last();

        return view('frontoffice.thermo',compact('thermos'));

    }

    public function attachThermo(Request $request)
    {
        $user = Auth::user();
        $inputs = $request->all();

        $newthermo = new ClientTHermo;
        $newthermo->user_id = $user->id;
        $newthermo->thermo_id = $inputs['imei'];
        $newthermo->save();

        return back();
    }
}