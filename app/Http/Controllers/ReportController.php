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
use App\User;
use App\Section;
use App\ClientSection;
use App\ControlCustomizationClients;
use App\Area;
use App\Equipment;
use App\CleanFrequency;
use App\AreaSectionClient;
use App\EquipmentSectionClient;
use App\TechnicalHACCP;
use App\RulesList;
use App\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class ReportController extends Controller
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

    public function getReportCover(){
        $auxClientId = Session::get('clientImpersonatedId');
        $auxTechnical = Session::get('impersonated');

        $establishName=Customer::where('id',$auxClientId)
        ->select(['name',])
        ->first();

        $technicalInfo = User::where('id',$auxTechnical)
        ->select(['id','name','userTypeID'])
        ->first();

        $countVisits= Report::where('idClient',$auxClientId)
        ->orderBy('id', 'desc')
        ->first();

        if( Carbon::now()->year > $countVisits->created_at->year){
            $visitNumber=1;
        }else{
            $visitNumber=$countVisits->numberVisit+1;
        }

        $date=Carbon::now()->toDateString();

        return view('frontoffice.newReportCover',compact('technicalInfo','visitNumber','establishName','date'));
    }


    public function getGeralRules(){
        
        $rules = RulesList::where('idSection',0)->get();

        return view('frontoffice.newReportGeralRules',compact('rules'));

    }
}