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
use App\ReportSectionObs;
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

        Session::forget('sectionsReport');
        Session::forget('reportId');

        $report = Report::where('idClient',$auxClientId)
        ->where('concluded',0)
        ->orderBy('id','desc')
        ->first();

        if(isset($report)){
            $establishName=Customer::where('id',$report->idClient)
            ->select(['name',])
            ->first();

            $technicalInfo = User::where('userTypeID',$report->id_tecnichal)
            ->where('userType',2)
            ->select(['id','name','userTypeID'])
            ->first();

            $visitNumber = $report->numberVisit;

            $sectionReportIds=RulesAnswerReport::where('idReport',$report->id)
            ->select(['idClientSection',])->groupBy('idClientSection')->get();

            Session::put('reportId',$report->id);

            if(count($sectionReportIds)>0){
                $arraySec=[];
                foreach($sectionReportIds as $sectionReportId){
                    array_push($arraySec,$sectionReportId->idClientSection);
                }
                Session::put('sectionsReport',$arraySec);
            }
        }else{
            $establishName=Customer::where('id',$auxClientId)
            ->select(['name',])
            ->first();

            $technicalInfo = User::where('id',$auxTechnical)
            ->select(['id','name','userTypeID'])
            ->first();

            $countVisits= Report::where('idClient',$auxClientId)
            ->orderBy('id', 'desc')
            ->first();

            if(!isset($countVisits)){
                $visitNumber=1;
            }else{
                if( Carbon::now()->year > $countVisits->created_at->year){
                    $visitNumber=1;
                }else{
                    $visitNumber=$countVisits->numberVisit+1;
                }
            }
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
        
        $answered=false;
        if(Session::get('sectionsReport') != null){
            $sectionsReport = Session::get('sectionsReport');
            foreach($sectionsReport as $sectionReport){
                if($sectionReport==$id){
                    $answered=true;
                }
            }
        }

        $idReport= Session::get('reportId');
        $showTableCorrective=0;

        if($answered){

            $reportSectionObs=ReportSectionObs::where('idReport',$idReport)
            ->where('idClientSection',$id)
            ->select(['id','observation','idRule'])
            ->get();

            $answersSection=RulesAnswerReport::where('idReport',$idReport)
            ->where('idClientSection',$id)
            ->select(['id','idRule','answer','corrective'])
            ->get();

            for($i=0; $i<count($rules); $i++){

                if($answersSection[$i]->corrective != null){
                    $showTableCorrective=1;
                    $rules[$i]->corrective= $answersSection[$i]->corrective;
                    $rules[$i]->showCorrective=1;
                }else{
                    $rules[$i]->showCorrective=0;
                }

                for($j=0;$j<count($reportSectionObs); $j++){
                    if($reportSectionObs[$j]->idRule==$rules[$i]->id){
                        $reportSectionObs[$j]->index=$i+1;
                    }
                }
                
                $rules[$i]->idAnswerReport=$answersSection[$i]->id;
                $rules[$i]->index=$i+1;
                $rules[$i]->answer=$answersSection[$i]->answer;
            }
            
        }else{

            $reportSectionObs=ReportSectionObs::where('idReport',$idReport)
            ->where('idClientSection',$id)
            ->select(['id','observation','idRule'])
            ->get();

            for($i=0; $i<count($rules); $i++){
                $rules[$i]->showCorrective=0;
                $rules[$i]->idAnswerReport=0;
                $rules[$i]->index=$i+1;
                $rules[$i]->answer='nd';
                $showTableCorrective=0;
            }
        }

        return view('frontoffice.newReportRules',compact('rules','section','showTableCorrective','reportSectionObs'));
    }

    public function getClientSection(){

        $auxClientId = Session::get('clientImpersonatedId');

        $clientSections=ClientSection::where('id_client',$auxClientId)
        ->where('active',1)
        ->select([
            'id',
            'id_section',
            'designation',
        ])->get();

        $geralClientSection=New ClientSection;
        $geralClientSection->id=0;
        $geralClientSection->id_section=0;
        $geralClientSection->designation="Geral";
        
        $clientSections->prepend($geralClientSection);

        if(Session::get('sectionsReport') != null){
            $arrayAuxs=Session::get('sectionsReport');
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
        Session::forget('sectionsReport');
    }
    
    private function addSectionReport($id){
        if(Session::get('sectionsReport') != null ){
            $arrayAuxSection=Session::get('sectionsReport');
            
            if(!in_array($id,$arrayAuxSection)){
                array_push($arrayAuxSection,$id);
                Session::put('sectionsReport',$arrayAuxSection);
            }
           
        }else{
            $arraySec=[];
            array_push($arraySec,$id);
            Session::put('sectionsReport',$arraySec);
        }
    }

    public function saveAnswers(Request $request){
        $inputs = $request->all();
        $answers = json_decode($inputs['answers']);
        $obs = json_decode($inputs['obs']);
        $idSection = json_decode($inputs['idSection']);

        $idReport = Session::get('reportId');
        $arrayAuxSection=Session::get('sectionsReport');

        if($arrayAuxSection != null){
            if(in_array($idSection,$arrayAuxSection)){
                foreach($answers as $answer){

                    $change1=false;
                    $change2=false;

                    $rulesAnswerReport=RulesAnswerReport::where('idReport',$idReport)
                    ->where('idRule',$answer->idRule)
                    ->first();
                    
                    if(!($rulesAnswerReport->answer == $answer->resp)){
                        $rulesAnswerReport->answer = $answer->resp;
                        $change1=true;
                    }

                    if(!($rulesAnswerReport->corrective == $answer->corrective)){
                        $rulesAnswerReport->corrective = $answer->corrective;
                        $change2=true;
                    }
        
                    if($change1 || $change2){
                       $rulesAnswerReport->save();
                    }
                }


            //obs
            $idObsList=ReportSectionObs::where('idReport',$idReport)
            ->where('idClientSection',$idSection)
            ->select(['id',])
            ->pluck('id')->all();

            foreach($obs as $o){
                if($o->idObs == 0){
                    $reportSectionObs = new ReportSectionObs;
                    $reportSectionObs->idReport=$idReport;
                    $reportSectionObs->observation=$o->observations;
                    $reportSectionObs->idRule=$o->rule;
                    $reportSectionObs->idClientSection=$idSection;
                    $reportSectionObs->save();
                }else{
                    $obsBD=ReportSectionObs::where('id',$o->idObs)
                    ->select(['id','observation'])
                    ->first();
    
                    if($obsBD->observation != $o->observations ){
                        $obsBD->observation=$o->observations;
                       $obsBD->save();
                    }

                    if (($key = array_search($o->idObs,$idObsList)) !== false) {
                        unset($idObsList[$key]);
                    }
                } 
            }
            foreach($idObsList as $idObs){
                $obsDelete=ReportSectionObs::where('id',$idObs)
                    ->delete();
            }

            }else{
                if(count($answers)>0){
                    foreach($answers as $answer){
                        $rulesAnswerReport = new RulesAnswerReport;
                        $rulesAnswerReport->idReport=$idReport;
                        $rulesAnswerReport->idRule=$answer->idRule;
                        $rulesAnswerReport->answer=$answer->resp;
                        $rulesAnswerReport->corrective=$answer->corrective;
                        $rulesAnswerReport->idClientSection=$idSection;
                        $rulesAnswerReport->save();
                    }
                }

                if(count($obs)>0){
                    foreach($obs as $o){
                        $reportSectionObs = new ReportSectionObs;
                        $reportSectionObs->idReport=$idReport;
                        $reportSectionObs->observation=$o->observations;
                        $reportSectionObs->idRule=$o->rule;
                        $reportSectionObs->idClientSection=$idSection;
                        $reportSectionObs->save();
                    }
                }
            }
        }else{
            if(count($answers)>0){
                foreach($answers as $answer){
                    $rulesAnswerReport = new RulesAnswerReport;
                    $rulesAnswerReport->idReport=$idReport;
                    $rulesAnswerReport->idRule=$answer->idRule;
                    $rulesAnswerReport->answer=$answer->resp;
                    $rulesAnswerReport->corrective=$answer->corrective;
                    $rulesAnswerReport->idClientSection=$idSection;
                    $rulesAnswerReport->save();
                }
            }

            if(count($obs)>0){
                foreach($obs as $o){
                    $reportSectionObs = new ReportSectionObs;
                    $reportSectionObs->idReport=$idReport;
                    $reportSectionObs->observation=$o->observations;
                    $reportSectionObs->idRule=$o->rule;
                    $reportSectionObs->idClientSection=$idSection;
                    $reportSectionObs->save();
                }
            }

        }

        $this->addSectionReport($idSection);
    }

    public function saveReport($visitNumber){
        if(Session::get('reportId') == null){
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

    public function concludeReport(){
        
        $idReport= Session::get('reportId');

        $report = Report::where('id',$idReport)
        ->first();

        $report->concluded=1;
        $report->save();

        Session::forget('sectionsReport');
        Session::forget('reportId');

        
        return redirect('/frontoffice/documents/HACCP');
    }

        
}