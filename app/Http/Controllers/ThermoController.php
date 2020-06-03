<?php

namespace App\Http\Controllers;


use App\ClientThermo;
use App\Fridge;
use App\FridgeType;
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
        $newthermo->imei = $inputs['imei'];
        $newthermo->save();

        return back();
    }

    public function getTemperature($imei)
    {
        $temperature = Thermo::where('imei',$imei)->get()->last()->temperature;

        return $temperature;
    }


    public function fridgeTypes()
    {
        $types = FridgeType::all();

        return view('frontoffice.fridge_types',compact('types'));
    }

    public function newFridgeType()
    {
        return view('fridges.new_fridge_type');
    }

    public function editFridgeType($id)
    {
        $fridge = FridgeType::where('id',$id)->first();

        return view('frontoffice.edit_fridge_type',compact('fridge'));
    }

    public function updateFridgeType(Request $request)
    {

    }

    public function fridge()
    {
        $fridges = Fridge::all();

        return view('frontoffice.fridges',compact('fridges'));

        
    }

    public function newFridge()
    {
        return view('frontoffice.new_fridge');
    }

    public function editFridge($id)
    {
        $fridge = Fridge::where('id',$id)->first();
        return view('frontoffice.edit_fridge',compact('fridge'));
    }

    public function updateFridge(Request $request)
    {

    }


}