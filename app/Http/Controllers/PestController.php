<?php

namespace App\Http\Controllers;


use App\AnswerDeviceMain;
use App\AnswerDeviceWarranty;
use App\Callback;
use App\Cart;
use App\Category;
use App\Customer;
use App\Devices;
use App\DocumentSuperType;
use App\DocumentType;
use App\Favorite;
use App\Group;
use App\Message;
use App\Order;
use App\ReportMaintenance;
use App\ReportPest;
use App\OrderLine;
use App\Product;
use App\Receipt;
use App\ReportPestObs;
use App\ReportPunctual;
use App\ReportPunctualData;
use App\ReportWarranty;
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
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\DocBlock\Tags\See;
use function Sodium\compare;


class PestController extends Controller
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

    public function firstService()
    {
        $auxClientId = Session::get('clientImpersonatedId');

        Session::forget('reportIdPest');
        Session::forget('reportIdWarranty');

        $client=Customer::where('id',$auxClientId)
            ->select(['ownerID'])
            ->first();

        $devices=Devices::where('idClient',$auxClientId)->get();

        return view('frontoffice.firstService',compact('devices','client'));
    }

    public function savefirstService(Request $request)
    {
        $inputs = $request->all();

        $auxClientId = Session::get('clientImpersonatedId');
        $auxTechnical = Session::get('impersonated');

        $countVisits= ReportPest::where('idClient',$auxClientId)
            ->orderBy('id', 'desc')
            ->first();

        $technicalInfo = User::where('id',$auxTechnical)
            ->select(['id','name'])
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

        $report_pest=new ReportPest;
        $report_pest->rating=$inputs['rating'];
        $report_pest->specie=$inputs['specie'];
        $report_pest->note=$inputs['note'];
        $report_pest->idClient=$auxClientId;
        $report_pest->numberVisit=$visitNumber;
        $report_pest->id_tecnichal=$technicalInfo->id;
        $report_pest->save();

        $devices= Devices::where('idClient',$auxClientId)->get();

        foreach ($devices as $device)
        {
            $device->idReportPest=$report_pest->id;
            $device->save();
        }

        $control= ControlCustomizationClients::where('idClient',$auxClientId)->first();
        $control->firstServicePest=1;
        $control->save();

        return redirect('/frontoffice/documents/Controlopragas');
    }

    public function newDevice()
    {
        $auxClientId = Session::get('clientImpersonatedId');
        $control= ControlCustomizationClients::where('idClient',$auxClientId)->first();
        $idReportMain=Session::get('reportIdPest');
        $idReportWarranty=Session::get('reportIdWarranty');

        return view('frontoffice.newDevice',compact('control','idReportWarranty','idReportMain'));
    }

    public function addDevice(Request $request)
    {
        $inputs=$request->all();
        $idReportMain=Session::get('reportIdPest');
        $idReportWarranty=Session::get('reportIdWarranty');

        $auxClientId = Session::get('clientImpersonatedId');

        $control= ControlCustomizationClients::where('idClient',$auxClientId)->first();

        if($control->firstServicePest==0)
        {
            $device= new Devices();
            $device->number_device=$inputs['num_device'];
            $device->cod_device=$inputs['cod_device'];
            $device->type_device=$inputs['type_device'];
            $device->specie=$inputs['type_specie'];
            $device->isco=$inputs['type_isco'];
            $device->idClient=$auxClientId;
            $device->active=1;
            $device->save();

            return redirect('/frontoffice/firstService');
        }elseif(isset($idReportMain))
        {
            $device= new Devices();
            $device->number_device=$inputs['num_device'];
            $device->cod_device=$inputs['cod_device'];
            $device->type_device=$inputs['type_device'];
            $device->specie=$inputs['type_specie'];
            $device->isco=$inputs['type_isco'];
            $device->idClient=$auxClientId;
            $device->active=1;
            $device->controlMain=1;
            $device->save();

            $answer_device=new AnswerDeviceMain();
            $answer_device->idReportMain=$idReportMain;
            $answer_device->id_device=$device->id;
            $answer_device->save();

            return redirect('/frontoffice/maintenance');
        }else
        {
            $device= new Devices();
            $device->number_device=$inputs['num_device'];
            $device->cod_device=$inputs['cod_device'];
            $device->type_device=$inputs['type_device'];
            $device->specie=$inputs['type_specie'];
            $device->isco=$inputs['type_isco'];
            $device->idClient=$auxClientId;
            $device->controlWarranty=1;
            $device->active=1;
            $device->save();

            $answer_device=new AnswerDeviceWarranty();
            $answer_device->idReportWarranty=$idReportWarranty;
            $answer_device->id_device=$device->id;
            $answer_device->save();

            return redirect('/frontoffice/warranty');
        }
    }

    public function replaceDevice($id,$idR){
        $auxClientId = Session::get('clientImpersonatedId');
        $control= ControlCustomizationClients::where('idClient',$auxClientId)->first();
        $idReport=$idR;
        $idReportMain=Session::get('reportIdPest');
        $idReportWarranty=Session::get('reportIdWarranty');

        $device = Devices::where('id',$id)
            ->select(['id','number_device','cod_device','specie','isco','type_device'])
            ->first();

        return view('frontoffice.replaceDevice',compact('control','device','idReport','idReportWarranty','idReportMain'));
    }
    public function saveReason(Request $request,$id,$idR)
    {
        $inputs = $request->all();

        $auxClientId = Session::get('clientImpersonatedId');
        $idReport=Session::get('reportIdPest');
        $idReportWarranty=Session::get('reportIdWarranty');

        if($idR!=0){
            if($inputs['new_device']=='sim'){
                $device=new Devices();
                $device->number_device=$inputs['num_device'];
                $device->cod_device=$inputs['cod_device'];
                $device->type_device=$inputs['type_device'];
                $device->specie=$inputs['type_specie'];
                $device->isco=$inputs['type_isco'];
                $device->idClient=$auxClientId;
                $device->controlMain=2;
                $device->active=1;
                $device->save();
                $answer_device=new AnswerDeviceMain();
                $answer_device->idReportMain=$idReport;
                $answer_device->id_device=$device->id;
                $answer_device->save();
            }else{
                $obs= new ReportPestObs();
                $obs->observation=$inputs['reason'];
                $obs->idReportMain=$idReport;
                $obs->idClient=$auxClientId;
                $obs->id_device=$id;
                $obs->save();
            }

            $answer_device=new AnswerDeviceMain();
            $answer_device->status='em falta';
            $answer_device->idReportMain=$idReport;
            $answer_device->id_device=$id;
            $answer_device->save();

            $controlD= Devices::where('id',$id)->first();
            $controlD->controlMain=1;
            $controlD->active=0;
            $controlD->save();

            return redirect('/frontoffice/maintenance');
        }else{
            if($inputs['new_device']=='sim'){
                $device=new Devices();
                $device->number_device=$inputs['num_device'];
                $device->cod_device=$inputs['cod_device'];
                $device->type_device=$inputs['type_device'];
                $device->specie=$inputs['type_specie'];
                $device->isco=$inputs['type_isco'];
                $device->idClient=$auxClientId;
                $device->idReportWarranty=$idReportWarranty;
                $device->controlWarranty=2;
                $device->active=1;
                $device->save();
                $answer_device=new AnswerDeviceWarranty();
                $answer_device->idReportWarranty=$idReportWarranty;
                $answer_device->id_device=$device->id;
                $answer_device->save();
            }else{
                $obs= new ReportPestObs();
                $obs->observation=$inputs['reason'];
                $obs->idReportWarranty=$idReportWarranty;
                $obs->idClient=$auxClientId;
                $obs->id_device=$id;
                $obs->save();
            }

            $answer_device=new AnswerDeviceWarranty();
            $answer_device->status='em falta';
            $answer_device->idReportWarranty=$idReportWarranty;
            $answer_device->id_device=$id;
            $answer_device->save();

            $controlD= Devices::where('id',$id)->first();
            $controlD->controlWarranty=1;
            $controlD->active=0;
            $controlD->save();

            return redirect('/frontoffice/warranty');
        }
    }

    public function  pestReportList()
    {

        $auxClientId = Session::has('clientImpersonatedId') ? Session::get('clientImpersonatedId') : Session::get('establismentID');

        $report_pest = ReportPest::where('idClient',$auxClientId)
            ->orderBy('id','asc')
            ->get();

        $report_maintenance=ReportMaintenance::where('idClient',$auxClientId)
            ->where('concluded',1)
            ->orderBy('id','asc')
            ->get();

        $report_punctual=ReportPunctual::where('idClient',$auxClientId)
            ->orderBy('id','asc')
            ->get();

        $report_warranty=ReportWarranty::where('idClient',$auxClientId)
            ->where('concluded',1)
            ->orderBy('id','asc')
            ->get();

        return view('frontoffice.pestReportList',compact('report_pest','report_maintenance','report_punctual','report_warranty'));
    }

    public function reportPestShow($id)
    {
        $auxClientId = Session::has('clientImpersonatedId') ? Session::get('clientImpersonatedId') : Session::get('establismentID');

        $report_pest = ReportPest::where('id',$id)
            ->where('idClient',$auxClientId)->first();

        $report_pest->technicalName= User::where('id',$report_pest->id_tecnichal)
            ->select(['name'])
            ->pluck('name')
            ->first();
        $report_pest->clientName=Customer::where('id',$report_pest->idClient)
            ->select(['name'])
            ->pluck('name')
            ->first();

        $devices=Devices::where('idClient',$auxClientId)
            ->where('idReportPest','=',$id)
            ->get();

        $count=0;

        foreach ($devices as $device)
        {
            $count++;
            $device->index=$count;
        }

        return view('frontoffice.reportPestShow',compact('report_pest','devices','device'));
    }

    public function maintenancePest()
    {
        $auxClientId = Session::get('clientImpersonatedId');
        $auxTechnical = Session::get('impersonated');
        Session::forget('reportIdPest');
        Session::forget('reportIdWarranty');
        Session::forget('lastReportIdPest');

        $lastReport=ReportMaintenance::where('idClient',$auxClientId)
            ->where('concluded',1)
            ->select(['id'])
            ->orderBy('id','desc')
            ->pluck('id')
            ->first();

        Session::put('lastReportId',$lastReport);

        $report = ReportMaintenance::where('idClient',$auxClientId)
            ->where('concluded',0)
            ->orderBy('id','desc')
            ->first();

        if(isset($report))
        {
            $client=Customer::where('id',$auxClientId)
                ->select(['ownerID'])
                ->first();

            Session::put('reportIdPest',$report->id);
        }else{

        $client=Customer::where('id',$auxClientId)
            ->select(['ownerID'])
            ->first();

        $technicalInfo = User::where('id',$auxTechnical)
            ->select(['id','name'])
            ->first();

        $countVisits= ReportMaintenance::where('idClient',$auxClientId)
            ->where('concluded',1)
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
            $report_MaintenancePest=new ReportMaintenance();
            $report_MaintenancePest->idClient=$auxClientId;
            $report_MaintenancePest->numberVisit=$visitNumber;
            $report_MaintenancePest->id_tecnichal=$technicalInfo->id;
            $report_MaintenancePest->concluded=0;
            $report_MaintenancePest->save();
            Session::put('reportIdPest',$report_MaintenancePest->id);
        }
        $idReport=Session::get('reportIdPest');

        $devices=Devices::where('idClient',$auxClientId)
            ->where('active',1)
            ->get();

       $checkDevices=Devices::where('idClient',$auxClientId)
           ->where('active',1)
           ->where('controlMain','!=',null)
           ->get();

        return view ('frontoffice.maintenancePest',compact('devices','client','idReport','checkDevices'));
    }

    public function saveMaintenance(Request $request)
    {
        $inputs = $request->all();

        $auxClientId = Session::get('clientImpersonatedId');
        $idReport=Session::get('reportIdPest');

        $report_MaintenancePest=ReportMaintenance::where('id',$idReport)->where('concluded',0)->first();

        $report_MaintenancePest->pest_presence=$inputs['pest_presence'];
        if($inputs['pest_presence']=='sim')
        {
            $report_MaintenancePest->specie=$inputs['type_specie'];
            $report_MaintenancePest->sub_active=$inputs['subs_active'];
        }else
        {
            $report_MaintenancePest->specie=null;
            $report_MaintenancePest->sub_active=null;
        }
        if(isset($inputs['action'])==0) $report_MaintenancePest->action = null; else $report_MaintenancePest->action=$inputs['action'];
        $report_MaintenancePest->note=$inputs['note'];
        $report_MaintenancePest->concluded=1;
        $report_MaintenancePest->save();

        $devices=Devices::where('idClient',$auxClientId)
            ->get();

        foreach ($devices as $device)
        {
            $device->controlMain=null;
            $device->save();
        }
        $devicesNews=Devices::where('idClient',$auxClientId)
            ->where('idReportPest',0)
            ->where('active',1)
            ->where('idReportMain',0)
            ->get();
        foreach ($devicesNews as $devicesNew)
        {
            $devicesNew->idReportMain=$report_MaintenancePest->id;
            $devicesNew->save();
        }
        Session::forget('reportIdPest');

        return redirect('/frontoffice/documents/Controlopragas');
    }

    public function getDeviceMaintenance($id)
    {
        $auxClientId = Session::get('clientImpersonatedId');

        $devices = Devices::where('id',$id)
            ->where('idClient',$auxClientId)->first();

        return view ('frontoffice.deviceMaintenance',compact('devices'));
    }

    public function saveDeviceMaintenance(Request $request, $id)
    {
        $idReport=Session::get('reportIdPest');

        $inputs = $request->all();
        $answer_device=new AnswerDeviceMain();
        $answer_device->status=$inputs['device_status'];
        if(isset($inputs['action'])==0) $answer_device->action = null; else $answer_device->action=$inputs['action'];
        $answer_device->id_device=$id;
        $answer_device->idReportMain=$idReport;
        $answer_device->save();

        $control= Devices::where('id',$id)->first();
        $control->controlMain=1;
        $control->save();

        return redirect('/frontoffice/maintenance');
    }

    public function reportMaintenanceShow($id)
    {
        $auxClientId = Session::has('clientImpersonatedId') ? Session::get('clientImpersonatedId') : Session::get('establismentID');

        $report_maintenance = ReportMaintenance::where('id',$id)
            ->where('idClient',$auxClientId)->first();

        $report_maintenance->technicalName= User::where('id',$report_maintenance->id_tecnichal)
            ->select(['name'])
            ->pluck('name')
            ->first();
        $report_maintenance->clientName=Customer::where('id',$report_maintenance->idClient)
            ->select(['name'])
            ->pluck('name')
            ->first();

        $answerDevices=AnswerDeviceMain::from(AnswerDeviceMain::alias('adm'))
            ->leftJoin(Devices::alias('d'),'adm.id_device','=','d.id')
            ->where('d.idClient',$auxClientId)
            ->where('adm.idReportMain','=',$id)
            ->where('adm.status','!=',null)
            ->select(['d.number_device','d.cod_device','d.specie','d.isco','d.type_device','adm.status','adm.action'])
            ->get();

            $newDevices=AnswerDeviceMain::from(AnswerDeviceMain::alias('adm'))
                ->leftJoin(Devices::alias('d'),'adm.id_device','=','d.id')
                ->where('adm.status',null)
                ->where('adm.idReportMain',$id)
                ->get();


        $obs=ReportPestObs::where('idReportMain',$id)->get();

        return view('frontoffice.reportMaintenanceShow',compact('report_maintenance','obs','id','answerDevices','newDevices'));
    }

    public function punctualPest()
    {
        $auxClientId = Session::get('clientImpersonatedId');

        $client=Customer::where('id',$auxClientId)
            ->select(['ownerID'])
            ->first();

        return view('frontoffice.punctualPest',compact('client'));
    }

    public function savePunctualPest(Request $request)
    {
        $inputs = $request->all();

        $auxClientId = Session::get('clientImpersonatedId');
        $auxTechnical = Session::get('impersonated');

        $countVisits= ReportPunctual::where('idClient',$auxClientId)
            ->orderBy('id', 'desc')
            ->first();

        $technicalInfo = User::where('id',$auxTechnical)
            ->select(['id','name'])
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

        $report_punctual= new ReportPunctual;
        $report_punctual->specie=$inputs['specie'];
        $report_punctual->note=$inputs['note'];
        $report_punctual->sub_active=$inputs['subs_active'];
        $report_punctual->action=$inputs['action'];
        $report_punctual->idClient=$auxClientId;
        $report_punctual->numberVisit=$visitNumber;
        $report_punctual->id_tecnichal=$technicalInfo->id;
        $report_punctual->save();

        return redirect('/frontoffice/documents/Controlopragas');
    }

    public function reportPunctualShow($idReport)
    {
        $auxClientId = Session::has('clientImpersonatedId') ? Session::get('clientImpersonatedId') : Session::get('establismentID');

        $report_punctual = ReportPunctual::where('id',$idReport)
            ->where('idClient',$auxClientId)->first();

        $report_punctual->technicalName= User::where('id',$report_punctual->id_tecnichal)
            ->select(['name'])
            ->pluck('name')
            ->first();
        $report_punctual->clientName=Customer::where('id',$report_punctual->idClient)
            ->select(['name'])
            ->pluck('name')
            ->first();

        return view('frontoffice.reportPunctualShow',compact('report_punctual','idReport'));
    }

  public function verifyCodeDeviceExist($id,$code){

      $count =  Devices::from(Devices::alias('d'))
          ->where('d.cod_device',$code)
          ->where('d.id',$id)
          ->count();

      if($count==0)
      {
          return 1;
      }else
          return 0;
    }

    public function warrantyPest()
    {
        $auxClientId = Session::get('clientImpersonatedId');
        $auxTechnical = Session::get('impersonated');
        Session::forget('reportIdWarranty');
        Session::forget('lastReportIdWarranty');
        Session::forget('reportIdPest');

        $lastReport=ReportWarranty::where('idClient',$auxClientId)
            ->where('concluded',1)
            ->select(['id'])
            ->orderBy('id','desc')
            ->pluck('id')
            ->first();

        Session::put('lastReportIdPest',$lastReport);

        $report = ReportWarranty::where('idClient',$auxClientId)
            ->where('concluded',0)
            ->orderBy('id','desc')
            ->first();

        if(isset($report))
        {
            $client=Customer::where('id',$auxClientId)
                ->select(['ownerID'])
                ->first();

            Session::put('reportIdWarranty',$report->id);
        }else{

            $client=Customer::where('id',$auxClientId)
                ->select(['ownerID'])
                ->first();

            $technicalInfo = User::where('id',$auxTechnical)
                ->select(['id','name'])
                ->first();

            $countVisits= ReportWarranty::where('idClient',$auxClientId)
                ->where('concluded',1)
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
            $report_WarrantyPest=new ReportWarranty();
            $report_WarrantyPest->idClient=$auxClientId;
            $report_WarrantyPest->numberVisit=$visitNumber;
            $report_WarrantyPest->id_tecnichal=$technicalInfo->id;
            $report_WarrantyPest->concluded=0;
            $report_WarrantyPest->save();
            Session::put('reportIdWarranty',$report_WarrantyPest->id);
        }

        $idReport=Session::get('reportIdWarranty');

        $devices=Devices::where('idClient',$auxClientId)
            ->where('active',1)
            ->get();


        return view ('frontoffice.warrantyPest',compact('devices','client','idReport'));
    }
    
    public function saveWarrantyPest(Request $request)
    {

        $inputs = $request->all();

        $auxClientId = Session::get('clientImpersonatedId');

        $idReport=Session::get('reportIdWarranty');

        $report_WarrantyPest=ReportWarranty::where('id',$idReport)->where('concluded',0)->first();

        $report_WarrantyPest->pest_presence=$inputs['pest_presence'];
        if($inputs['pest_presence']=='sim')
        {
            $report_WarrantyPest->specie=$inputs['type_specie'];
            $report_WarrantyPest->sub_active=$inputs['subs_active'];
        }else
        {
            $report_WarrantyPest->specie=null;
            $report_WarrantyPest->sub_active=null;
        }
        if(isset($inputs['action'])==0) $report_WarrantyPest->action = null; else $report_WarrantyPest->action=$inputs['action'];
        $report_WarrantyPest->note=$inputs['note'];
        $report_WarrantyPest->concluded=1;

        $report_WarrantyPest->save();

        $devices=Devices::where('idClient',$auxClientId)
            ->get();

        foreach ($devices as $device)
        {
            $device->controlWarranty=null;
            $device->save();
        }
        $devicesNews=Devices::where('idClient',$auxClientId)
            ->where('idReportPest',0)
            ->where('active',1)
            ->where('idReportWarranty',0)
            ->get();
        foreach ($devicesNews as $devicesNew)
        {
            $devicesNew->idReportMain=$idReport;
            $devicesNew->save();
        }
        Session::forget('reportIdWarranty');

        return redirect('/frontoffice/documents/Controlopragas');
    }

    public function reportWarrantyShow($id)
    {
        $auxClientId = Session::has('clientImpersonatedId') ? Session::get('clientImpersonatedId') : Session::get('establismentID');

        $report_warranty = ReportWarranty::where('id',$id)
            ->where('idClient',$auxClientId)->first();

        $report_warranty->technicalName= User::where('id',$report_warranty->id_tecnichal)
            ->select(['name'])
            ->pluck('name')
            ->first();
        $report_warranty->clientName=Customer::where('id',$report_warranty->idClient)
            ->select(['name'])
            ->pluck('name')
            ->first();

        $answerDevices=AnswerDeviceWarranty::from(AnswerDeviceWarranty::alias('adw'))
            ->leftJoin(Devices::alias('d'),'adw.id_device','=','d.id')
            ->where('d.idClient',$auxClientId)
            ->where('adw.status','!=',null)
            ->where('adw.idReportWarranty','=',$id)
            ->select(['d.number_device','d.cod_device','d.type_device','d.specie','d.isco','d.type_device','adw.status','adw.action'])
            ->get();

        $newDevices=AnswerDeviceWarranty::from(AnswerDeviceWarranty::alias('adw'))
            ->leftJoin(Devices::alias('d'),'adw.id_device','=','d.id')
            ->where('adw.status',null)
            ->where('adw.idReportWarranty',$id)
            ->get();

        $obs=ReportPestObs::where('idReportWarranty',$id)->get();

        return view('frontoffice.reportWarrantyShow',compact('report_warranty','id','answerDevices','device','newDevices','obs'));
    }
    public function getDeviceWarranty($id)
    {
        $auxClientId = Session::get('clientImpersonatedId');

        $devices = Devices::where('id',$id)
            ->where('idClient',$auxClientId)->first();

        return view ('frontoffice.deviceWarranty',compact('devices'));
    }

    public function saveDeviceWarranty(Request $request, $id)
    {

        $idReport=Session::get('reportIdWarranty');

        $inputs = $request->all();

        $answer_device=new AnswerDeviceWarranty();
        $answer_device->status=$inputs['device_status'];
        if(isset($inputs['action'])==0) $answer_device->action = null; else $answer_device->action=$inputs['action'];
        $answer_device->idReportWarranty=$idReport;
        $answer_device->id_device=$id;
        $answer_device->save();

        $control= Devices::where('id',$id)->first();
        $control->controlWarranty=1;
        $control->save();

        return redirect('/frontoffice/warranty');
    }

    public function getList()
    {
        $punctual_datas=ReportPunctualData::get();

        return view('frontoffice.punctualPestDataList',compact('punctual_datas'));
    }
    public function punctualData()
    {
        return view('frontoffice.punctualPestData');
    }
    public function savePunctualData(Request $request)
    {
        $inputs = $request->all();

        $punctual_data=new ReportPunctualData();
        $punctual_data->name=$inputs['name'];
        $punctual_data->address=$inputs['address'];
        $punctual_data->nif=$inputs['nif'];
        $punctual_data->value=$inputs['value'];
        $punctual_data->specie=$inputs['specie'];
        $punctual_data->note=$inputs['note'];
        $punctual_data->sub_active=$inputs['subs_active'];
        if(isset($inputs['action'])==0) $punctual_data->action = null; else $punctual_data->action=$inputs['action'];
        $punctual_data->save();

        return redirect('/frontoffice/reports/punctualList');
    }
    public function punctualDataShow($id)
    {
        $report_punctual_data = ReportPunctualData::where('id',$id)
            ->first();

        $report_punctual_data->technicalName= User::where('userTypeID',$report_punctual_data->id_tecnichal)
            ->where('userType',3)
            ->select(['name'])
            ->pluck('name')
            ->first();

        return view('frontoffice.punctualDataShow',compact('report_punctual_data','idReport'));
    }

    public function verifyPin($id,$pin)
    {
        $pinClient=User::where('id',$id)
            ->select(['pin'])
            ->first();

        if(password_verify($pin, $pinClient->pin)) {
           return 1;
        }else
            return 0;
    }
}