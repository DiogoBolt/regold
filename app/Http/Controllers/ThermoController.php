<?php

namespace App\Http\Controllers;

use App\Callback;
use App\Cart;
use App\Category;
use App\Customer;
use App\DocumentSuperType;
use App\DocumentType;
use App\Favorite;
use App\Group;
use App\Message;
use App\Order;
use App\OrderLine;
use App\Product;
use App\Receipt;
use App\Thermo;
use App\User;
use App\Section;
use App\ClientSection;
use App\ControlCustomizationClients;
use App\Area;
use App\Equipment;
use App\CleanFrequency;
use App\AreaSectionClient;
use App\EquipmentSectionClient;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


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

        $thermo->client_id = "Teste";
        $thermo->thermo_type ="Teste";
        $thermo->temperature = $inputs;
        $thermo->last_read = Carbon::now();

        $thermo->save();


        return 200;
    }

}