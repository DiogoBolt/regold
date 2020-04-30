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
        Session::forget('lastReportId');

        $lastReport=Report::where('idClient',$auxClientId)
        ->where('concluded',1)
        ->select(['id'])
        ->orderBy('id','desc')
        ->pluck('id')
        ->first();

        Session::put('lastReportId',$lastReport);

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
        $auxClientId = Session::get('clientImpersonatedId');

        //verificar se é o primeiro relatorio caso seja não há reincidencias
        if(Session::get('lastReportId')==null){
            $showColumnRecidivist=0;
        }else{
            $showColumnRecidivist=1;
        }

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
            ->select(['id','idRule','answer','corrective','severityValue'])
            ->get();

            for($i=0; $i<count($rules); $i++){

                if($answersSection[$i]->corrective != null){
                    $showTableCorrective=1;
                    $rules[$i]->corrective= $answersSection[$i]->corrective;
                    $rules[$i]->showCorrective=1;
                }else{
                    $rules[$i]->showCorrective=0;
                }

                for($j=0;$j<count($reportSectionObs);$j++){
                    if($reportSectionObs[$j]->idRule==$rules[$i]->id){
                        $reportSectionObs[$j]->index=$i+1;
                    }
                }
                
                $rules[$i]->severityValue=$answersSection[$i]->severityValue;

                if($answersSection[$i]->severityValue==1 || $answersSection[$i]->severityValue==2 ){
                    $rules[$i]->severityText="Não Crítico";
                }else if($answersSection[$i]->severityValue==3 || $answersSection[$i]->severityValue==4 ){
                    $rules[$i]->severityText="Moderado";
                }else if($answersSection[$i]->severityValue==5){
                    $rules[$i]->severityText="Crítico";
                }
                
                $rules[$i]->idAnswerReport=$answersSection[$i]->id;
                $rules[$i]->index=$i+1;
                $rules[$i]->answer=$answersSection[$i]->answer;
            }
            
        }else{
            
            if(Session::get('lastReportId')!=null){
                //aqui já sei se existem ou não relatorios....

                //array com os id's dos relatorios anteriores completos
                $lastReportsListIds=Report::where('idClient',$auxClientId)
                    ->where('concluded',1)
                    ->select(['id'])
                    ->pluck('id')
                    ->all();
                
                $rulesLastReportAnswers=RulesAnswerReport::where('idReport',Session::get('lastReportId'))
                ->where('idClientSection',$id)
                ->get();

                $reportSectionObs=ReportSectionObs::where('idReport',Session::get('lastReportId'))
                ->where('idClientSection',$id)
                ->select(['id','observation','idRule'])
                ->get();

                for($i=0; $i<count($rules); $i++){

                    $recidivistCount=0;

                    //for para contar o numero de reincidencias
                    for($k=0; $k<count($lastReportsListIds); $k++){
                        $auxTest=RulesAnswerReport::where('idReport',$lastReportsListIds[$k])
                        ->where('idRule',$rules[$i]->id)
                        ->select(['answer'])
                        ->pluck('answer')
                        ->first();
                        if($auxTest=='nc'){
                            $recidivistCount++;
                        }
                    }

                    $rules[$i]->recidivistCount=$recidivistCount;

                    $existLastReport=false;
                    $indexExistLastReport=-1;
                    
                    for($x=0;$x<count($reportSectionObs);$x++){
                        if($reportSectionObs[$x]->idRule==$rules[$i]->id){
                            $reportSectionObs[$x]->index=$i+1;
                        }
                    }

                    for($j=0; $j<count($rulesLastReportAnswers); $j++){
                        
                        $rules[$i]->index=$i+1;

                        if($rules[$i]->id == $rulesLastReportAnswers[$j]->idRule){
                            $existLastReport=true;
                            $indexExistLastReport=$j;
                            break;
                        }else{
                            $existLastReport=false;
                        }
                    }
                    if($existLastReport){
                        
                        if($rulesLastReportAnswers[$indexExistLastReport]->answer=="nc"){
                            $rules[$i]->showCorrective=1;
                            $rules[$i]->corrective=$rulesLastReportAnswers[$indexExistLastReport]->corrective;
                            $rules[$i]->answer=$rulesLastReportAnswers[$indexExistLastReport]->answer;
                            $showTableCorrective=1;
                        }else{
                            $rules[$i]->showCorrective=0;
                            $rules[$i]->answer=$rulesLastReportAnswers[$indexExistLastReport]->answer;
                        }
                         
                        $rules[$i]->severityValue=$rulesLastReportAnswers[$indexExistLastReport]->severityValue;

                        if($rules[$i]->severityValue==1 || $rules[$i]->severityValue==2 ){
                            $rules[$i]->severityText="Não Crítico";
                        }else if($rules[$i]->severityValue==3 || $rules[$i]->severityValue==4 ){
                            $rules[$i]->severityText="Moderado";
                        }else if($rules[$i]->severityValue==5){
                            $rules[$i]->severityText="Crítico";
                        }
                    }else{
                        $rules[$i]->showCorrective=0;
                        $rules[$i]->idAnswerReport=0;
                        $rules[$i]->index=$i+1;
                        $rules[$i]->answer='nd';
                        if($rules[$i]->severityValue==1 || $rules[$i]->severityValue==2 ){
                            $rules[$i]->severityText="Não Crítico";
                        }else if($rules[$i]->severityValue==3 || $rules[$i]->severityValue==4 ){
                            $rules[$i]->severityText="Moderado";
                        }else if($rules[$i]->severityValue==5){
                            $rules[$i]->severityText="Crítico";
                        }
                    }
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
        }
        //dd($showColumnRecidivist);
        return view('frontoffice.newReportRules',compact('rules','section','showTableCorrective','reportSectionObs','showColumnRecidivist'));
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
                    $change3=false;

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

                    if(!($rulesAnswerReport->severityValue == $answer->severityValue)){
                        $rulesAnswerReport->severityValue = $answer->severityValue;
                        $change3=true;
                    }
        
                    if($change1 || $change2 || $change3){
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
                        $rulesAnswerReport->severityValue=$answer->severityValue;
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
                    $rulesAnswerReport->severityValue=$answer->severityValue;
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

    public function reportList(){
        $auxClientId = Session::get('clientImpersonatedId');
        $reports = Report::where('idClient',$auxClientId)
        ->where('concluded',1)
        ->orderBy('id','desc')
        ->get();
        return view('frontoffice.reportsList',compact('reports'));
    }

    public function reportShow($idReport){
        $auxClientId = Session::get('clientImpersonatedId');
        
        $report = Report::where('id',$idReport)
        ->where('idClient',$auxClientId)->first();

        $report->technicalName= User::where('userTypeID',$report->id_tecnichal)
        ->where('userType',2)
        ->select(['name'])
        ->pluck('name')
        ->first();
        $report->clientName=Customer::where('id',$report->idClient)
        ->select(['name'])
        ->pluck('name')
        ->first();

        User::where('userTypeID',$report->id_tecnichal)
            ->where('userType',2)
            ->select(['id','name','userTypeID'])
            ->first();

        $sectionReportIds=RulesAnswerReport::where('idReport',$report->id)
        ->select(['idClientSection',])
        ->groupBy('idClientSection')
        ->pluck('idClientSection')
        ->all();

        $reportsAnswers=RulesAnswerReport::where('idReport',$report->id)
        ->get();

        //for para ir buscar as regras
        foreach($reportsAnswers as $reportsAnswer){
            $reportsAnswer->rule=RulesList::where('id',$reportsAnswer->idRule)
            ->select(['rule'])
            ->pluck('rule')
            ->first();
        }
        
        //secção para ir buscar os dados das secçoes pelo id
        $arraySections=[];

        foreach($sectionReportIds as $sectionReportId){
            if($sectionReportId!=0){
                $sectionInfo=ClientSection::where('id',$sectionReportId)
                ->select([
                    'id',
                    'id_section',
                    'designation',
                ])->first();
                
                array_push($arraySections,$sectionInfo);
            }
        }

        $geralClientSection=New ClientSection;
        $geralClientSection->id=0;
        $geralClientSection->id_section=0;
        $geralClientSection->designation="Geral";

        array_unshift($arraySections,$geralClientSection);

        $reportSectionObs=ReportSectionObs::where('idReport',$report->id)
        ->select(['id','observation','idRule','idClientSection'])
        ->get();

        //for para verificar se para cada secção existe medidas corretivas e obs
        foreach($arraySections as $section){
            $existCorrective=false;
            $existObs=false;
            foreach($reportsAnswers as $reportsAnswer){
                if($section->id == $reportsAnswer->idClientSection){
                    if($reportsAnswer->corrective != null){
                        $existCorrective=true;
                        break;
                    }
                }
            }

            foreach($reportSectionObs as $reportSectionOb){
                if($section->id == $reportSectionOb->idClientSection){
                    $existObs=true;
                }
            }

            if($existCorrective){
                $section->showCorrective=1;
            }else{
                $section->showCorrective=0;
            }

            if($existObs){
                $section->showObs=1;
            }else{
                $section->showObs=0;
            }
        }
      
        //for para meter o valor do index para cada "regra"
        foreach($arraySections as $section){
            $count=0;
            foreach($reportsAnswers as $reportsAnswer){
                if($section->id == $reportsAnswer->idClientSection){
                    $count++;
                    $reportsAnswer->index=$count;
                }
                foreach($reportSectionObs as $reportSectionOb){
                    if($reportSectionOb->idClientSection==$reportsAnswer->idClientSection && 
                        $reportSectionOb->idRule == $reportsAnswer->idRule){
                            $reportSectionOb->index=$reportsAnswer->index;
                        }
                }
            }
        }

        //foreach estatiststicas 
        foreach($arraySections as $section){
            //estatisticas Secão 
            $totalRules=0;
            $totalConforme=0;
            $totalnConforme=0;
            $totalnAplicavel=0;
            foreach($reportsAnswers as $reportsAnswer){
                if($section->id == $reportsAnswer->idClientSection){
                    $totalRules++;
                    if($reportsAnswer->answer=='c'){
                        $totalConforme++;
                    }else if($reportsAnswer->answer=='nc'){
                        $totalnConforme++;
                    }else if($reportsAnswer->answer=='na'){
                        $totalnAplicavel++;
                    }
                }
                
            }
            $totalRules == 0 ? $auxPerConf=0 :  $auxPerConf=intval(round(($totalConforme*100)/$totalRules));

            $totalRules == 0 ?  $auxPerNCont=0: $auxPerNCont=intval(round(($totalnConforme*100)/$totalRules,0));

            $totalRules == 0 ? $auxPerNApply=0 : $auxPerNApply=intval(round(($totalnAplicavel*100)/$totalRules,0));

            $section->conforme=$auxPerConf;
            $section->nConforme=$auxPerNCont;
            $section->nApply=$auxPerNApply;
        }


        //estatisticas geral e por a mensagem de severidade 
        $totalRulesGeral=0;
        $totalConformeGeral=0;
        $totalnConformeGeral=0;
        $totalnAplicavelGeral=0;
        foreach($reportsAnswers as $reportsAnswer){

            if($reportsAnswer->severityValue==1 || $reportsAnswer->severityValue==2 ){
                $reportsAnswer->severityText="Não Crítico";
            }else if($reportsAnswer->severityValue==3 || $reportsAnswer->severityValue==4 ){
                $reportsAnswer->severityText="Moderado";
            }else if($reportsAnswer->severityValue==5){
                $reportsAnswer->severityText="Crítico";
            }

            $totalRulesGeral++;
            if($reportsAnswer->answer=='c'){
                $totalConformeGeral++;
            }else if($reportsAnswer->answer=='nc'){
                $totalnConformeGeral++;
            }else if($reportsAnswer->answer=='na'){
                $totalnAplicavelGeral++;
            }
        }

        $totalRulesGeral == 0 ? $auxPerConfGeral=0 : $auxPerConfGeral=intval(round(($totalConformeGeral*100)/$totalRulesGeral));
        $totalRulesGeral == 0 ? $auxPerNConfGeral=0 : $auxPerNConfGeral=intval(round(($totalnConformeGeral*100)/$totalRulesGeral));
        $totalRulesGeral == 0 ? $auxPerNApplyGeral=0 : $auxPerNApplyGeral=intval(round(($totalnAplicavelGeral*100)/$totalRulesGeral));

        $statiscsGeral = (object)[];
        $statiscsGeral->confGeral=$auxPerConfGeral;
        $statiscsGeral->nConfGeral=$auxPerNConfGeral;
        $statiscsGeral->nAplly=$auxPerNApplyGeral;

        return view('frontoffice.reportShow',compact('report','arraySections','reportsAnswers','reportSectionObs','statiscsGeral'));
    }

    public function reportStatistics(){
        return view('frontoffice.reportStatistics');
    } 
        
}