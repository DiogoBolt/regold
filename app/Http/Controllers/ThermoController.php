<?php

namespace App\Http\Controllers;


use App\ClientThermo;
use App\Thermo;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


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

        $clientThermos = ClientThermo::where('user_id',$user->id)->get();

        $thermos = [];

        foreach($clientThermos as $clientthermo)
        {
            $thermos[$clientthermo->imei] = 0;
        }

        foreach ($thermos as $key => $value)
        {
            $temperature = Thermo::where('imei',$key)->get()->last()->temperature;
            $thermos[$key] = $temperature;
        }

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

    public function getTemperature($imei)
    {
        $temperature = Thermo::where('imei',$imei)->get()->last()->temperature;

        return $temperature;
    }
}