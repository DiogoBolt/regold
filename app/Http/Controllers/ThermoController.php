<?php

namespace App\Http\Controllers;


use App\ClientThermo;
use App\Fridge;
use App\FridgeType;
use App\Thermo;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


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
        $newthermo->user_id = Session::get('establismentID');
        $newthermo->imei = $inputs['imei'];
        $newthermo->type = $inputs['type'];
        $newthermo->number = $inputs['number'];
        $newthermo->save();

        return back();
    }

    public function deleteThermo(Request $request)
    {
        try {
            $id_to_delete = $request->get('id');

            $thermo = ClientThermo::query()->findOrFail($id_to_delete);
            $thermo->delete();

            return back();
        } catch (\Exception $exception ) {
            return back()->withErrors(['msg' => 'Ocorreu um erro, por favor tente mais tarde.']);
        }
    }

    public function getTemperature($imei)
    {
        $temperature = Thermo::where('imei',$imei)->get()->last()->temperature;

        return $temperature;
    }



}