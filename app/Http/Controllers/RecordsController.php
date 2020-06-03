<?php
namespace App\Http\Controllers;
use App\Cart;
use App\Category;
use App\Customer;
use App\DocumentType;
use App\Group;
use App\Message;
use App\Order;
use App\OrderLine;
use App\OilRecord;
use App\Product;
use App\Receipt;
use App\Salesman;
use App\SalesPayment;
use App\User;
use App\Districts;
use App\Cities;
use App\UserType;
use App\TechnicalHACCP;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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

}