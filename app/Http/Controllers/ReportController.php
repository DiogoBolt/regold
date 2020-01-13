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
use App\RulesAnswerReport;
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


    public function getRules($id){
        if($id==0){
            $section = new ClientSection;
            $section->id = 0;
            $section->id_section= 0;
            $section->designation= "Geral";
        }else{
            $section=ClientSection::where('id',$id)
            ->select(['id','id_section','designation'])
            ->first();
        }

        $rules = RulesList::where('idSection',$section->id_section)->get();

        $count=0;
        
        foreach($rules as $rule){
            ++$count;
            $rule->index=$count;
        }

        return view('frontoffice.newReportRules',compact('rules','section'));

    }

    //$GLOBALS['sectionReport'] = sectioReport();

    public function addSectionReport($id){
        if(Session::get('sectionsReport') != null ){
            $arrayAuxSection=Session::get('sectionsReport');
            array_push($arrayAuxSection,$id);
            Session::put('sectionsReport',$arrayAuxSection);
        }else{
            $arraySec=[];
            array_push($arraySec,$id);
            Session::put('sectionsReport',$arraySec);
        }
    }

    public function getClientSection(){

        $auxClientId = Session::get('clientImpersonatedId');

        $clientSections=ClientSection::where('id_client',$auxClientId)
        ->where('active',1)
        ->select([
            'id',
            'id_section',
            'designation',
            'wasPersonalized',
        ])->get();

        if(Session::get('sectionsRepost') != null){
            //dd(Session::get('sectionsRepost'));
            $arrayAuxs=Session::get('sectionsRepost');
            foreach($clientSections as $clientSection){
                $exist=false;
                foreach($arrayAuxs as $arrayAux){
                    if($clientSection->id == $arrayAux){
                        $exist=true;
                    }
                }
                if($exist){
                    $clientSection->answered=1;
                }else{
                    $clientSection->answered=0; 
                }
            }
        }
        return view('frontoffice.newReportSections',compact('clientSections'));
    }


    public function forgetSessionVar(){
        Session::forget('sectionsRepost');
    }

    public function saveAnswers(Request $request){
        $inputs = $request->all();
        $answers = json_decode($inputs['answers']);
        $obs = json_decode($inputs['obs']);
        $idSection=json_decode($inputs['idSection']);

        $idReport= Session::get('reportId');

        if(count($answers)>0){
            foreach($answers as $answer){
                $rulesAnswerReport = new RulesAnswerReport;
                $rulesAnswerReport->idReport=$idReport;
                $rulesAnswerReport->idRule=$answer->idRule;
                $rulesAnswerReport->answer=$answer->resp;
                $rulesAnswerReport->corrective=$answer->corrective;
                $rulesAnswerReport->save();
            }
        }
        $this->addSectionReport($idReport);

        dd(Session::get('sectionsReport'));
    }

    public function saveReport($visitNumber){
        //dd($visitNumber);
        $auxClientId = Session::get('clientImpersonatedId');
        $auxTechnical = Session::get('impersonated');

        $technicalInfo = User::where('id',$auxTechnical)
        ->select(['id','name','userTypeID'])
        ->first();

        $report= new Report;
        $report->idClient=$auxClientId;
        $report->id_tecnichal=$technicalInfo->userTypeID;
        $report->numberVisit=$visitNumber;
        $report->save();

        Session::put('reportId',$report->id);
    }
}