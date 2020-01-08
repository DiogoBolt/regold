<?php

namespace App\Http\Controllers;


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


    public function receiveThermo(Request $request)
    {
        $inputs = $request->all();

        $thermo = new Thermo;

        $thermo->client_id = 0;
        $thermo->thermo_type ="Teste";
        $thermo->temperature = json_encode($inputs);
        $thermo->last_read = Carbon::now();

        $thermo->save();


        return 200;
    }

}