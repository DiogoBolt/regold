<?php
namespace App\Http\Controllers;

use App\OilRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class RecordsController extends Controller
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

    public function insertConformities()
    {


        return view('frontoffice.insertProductConformities',compact('oil_records'));
    }

    public function insertOilRecords()
    {
        /*$UserTypes = UserType::all();*/


        return view('frontoffice.oilRecords'/*,compact('UserTypes')*/);

    }
    public function saveOilRecords(Request $request)
    {
        dd("dsf");
        $user = Auth::user();

        $auxClientId = Session::get('establismentID');

        $inputs = $request->all();

        $oil_records= new OilRecord();
        $oil_records->report_date= $inputs['report_date'];
        $oil_records->oil_aspect=$inputs['oil_aspect'];

        $oil_records->client_id = $auxClientId;

        $oil_records->save();

        return redirect('/frontoffice/documents/Registos',compact('oil_records'));
    }

    public function getTemperaturesRecords()
    {
        return view('frontoffice.temperatureRegister');
    }
}