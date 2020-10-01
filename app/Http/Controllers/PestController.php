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

        $report_pest = Report::where('idClient',$auxClientId)
            ->first();

        $client=Customer::where('id',$auxClientId)
            ->select(['ownerID'])
            ->first();

        $devices=Devices::where('idClient',$auxClientId)->get();

        $count=0;

        foreach ($devices as $device)
        {
            $count++;
            $device->index=$count;
        }

        return view('frontoffice.firstService',compact('devices','client','report_pest'));
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
            ->select(['id','name','userTypeID'])
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
        $report_pest->id_tecnichal=$technicalInfo->userTypeID;
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

        return view('frontoffice.newDevice',compact('control'));
    }

    public function addDevice(Request $request)
    {
        $inputs=$request->all();

        $auxClientId = Session::get('clientImpersonatedId');
        $auxTechnical = Session::get('impersonated');

        $technicalInfo = User::where('id',$auxTechnical)
            ->select(['id','name','userTypeID'])
            ->first();

        $device=new Devices();
        $device->number_device=$inputs['num_device'];
        $device->cod_device=$inputs['cod_device'];
        $device->specie=$inputs['type_specie'];
        $device->isco=$inputs['type_isco'];
        $device->idClient=$auxClientId;
        $device->id_tecnichal=$technicalInfo->userTypeID;
        $device->save();

        $control= ControlCustomizationClients::where('idClient',$auxClientId)->first();

        if($control->firstServicePest==0)
        {
            return redirect('/frontoffice/firstService');
        }else
        {
            return redirect('/frontoffice/maintenance');
        }

    }
    public function  pestReportList()
    {
        $auxClientId = Session::get('clientImpersonatedId');
        $report_pest = ReportPest::where('idClient',$auxClientId)
            ->orderBy('id','desc')
            ->get();

        $report_maintenance=ReportMaintenance::where('idClient',$auxClientId)
            ->orderBy('id','desc')
            ->get();

        $report_punctual=ReportPunctual::where('idClient',$auxClientId)
            ->orderBy('id','desc')
            ->get();

        $report_warranty=ReportWarranty::where('idClient',$auxClientId)
            ->orderBy('id','desc')
            ->get();

        return view('frontoffice.pestReportList',compact('report_pest','report_maintenance','report_punctual','report_warranty'));
    }

    public function reportPestShow($id)
    {
        $auxClientId = Session::get('clientImpersonatedId');

        $report_pest = ReportPest::where('id',$id)
            ->where('idClient',$auxClientId)->first();

        $report_pest->technicalName= User::where('userTypeID',$report_pest->id_tecnichal)
            ->where('userType',3)
            ->select(['name'])
            ->pluck('name')
            ->first();
        $report_pest->clientName=Customer::where('id',$report_pest->idClient)
            ->select(['name'])
            ->pluck('name')
            ->first();

        User::where('userTypeID',$report_pest->id_tecnichal)
            ->where('userType',3)
            ->select(['id','name','userTypeID'])
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

        return view('frontoffice.reportPestShow',compact('report_pest','idReport','devices','device'));
    }

    public function maintenancePest()
    {
        $auxClientId = Session::get('clientImpersonatedId');



        $client=Customer::where('id',$auxClientId)
            ->select(['ownerID'])
            ->first();




        $devices=Devices::where('idClient',$auxClientId)->get();
        $count=0;

        /*$abc=Devices::where('idClient',$auxClientId)
            ->where('status','!=',null)
            ->get();*/

        foreach ($devices as $device)
        {
            $count++;
            $device->index=$count;
        }

        return view ('frontoffice.maintenancePest',compact('devices','client'));
    }

    public function saveMaintenance(Request $request)
    {
        $inputs = $request->all();

        $auxClientId = Session::get('clientImpersonatedId');
        $auxTechnical = Session::get('impersonated');

        $technicalInfo = User::where('id',$auxTechnical)
            ->select(['id','name','userTypeID'])
            ->first();

        $countVisits= ReportMaintenance::where('idClient',$auxClientId)
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
        $report_MaintenancePest->note=$inputs['note'];
        $report_MaintenancePest->idClient=$auxClientId;
        $report_MaintenancePest->numberVisit=$visitNumber;
        $report_MaintenancePest->id_tecnichal=$technicalInfo->userTypeID;
        $report_MaintenancePest->save();

        $answerDevices= AnswerDeviceMain::where('idClient',$auxClientId)
            ->where('idReportMain','=',0)
            ->get();

        foreach ($answerDevices as $answerDevice)
        {
            $answerDevice->idReportMain=$report_MaintenancePest->id;
            $answerDevice->save();
        }

        $devices=Devices::where('idClient',$auxClientId)->get();
        foreach ($devices as $device)
        {
            $device->controlMain=null;
            $device->save();
        }

        return redirect('/frontoffice/documents/Controlopragas');
    }

    public function getDeviceMaintenance($id)
    {
        $auxClientId = Session::get('clientImpersonatedId');


        $devices = Devices::where('id',$id)
            ->where('idClient',$auxClientId)->first();

        /*$count=0;

        foreach ($devices as $device)
        {
            $count++;
            $device->index=$count;
        }*/

        return view ('frontoffice.deviceMaintenance',compact('devices'));
    }

    public function saveDeviceMaintenance(Request $request, $id)
    {
        $auxClientId = Session::get('clientImpersonatedId');

        $device = Devices::where('id',$id)
            ->select(['number_device','cod_device','specie','isco'])
            ->first();

        $inputs = $request->all();

        $answer_device=new AnswerDeviceMain();
        $answer_device->status=$inputs['device_status'];
        $answer_device->idClient=$auxClientId;
        $answer_device->number_device=$device->number_device;
        $answer_device->cod_device=$device->cod_device;
        $answer_device->specie=$device->specie;
        $answer_device->isco=$device->isco;
        $answer_device->id_device=$id;
        $answer_device->save();

        $control= Devices::where('id',$id)->first();
        $control->controlMain=1;
        $control->save();

        if($answer_device->status=='em falta')
        {
            $answer_device=Devices::where('id','=', $id)->delete();
        }

        return redirect('/frontoffice/maintenance');
    }

    public function reportMaintenanceShow($id)
    {
        $auxClientId = Session::get('clientImpersonatedId');

        $report_maintenance = ReportMaintenance::where('id',$id)
            ->where('idClient',$auxClientId)->first();

        $report_maintenance->technicalName= User::where('userTypeID',$report_maintenance->id_tecnichal)
            ->where('userType',3)
            ->select(['name'])
            ->pluck('name')
            ->first();
        $report_maintenance->clientName=Customer::where('id',$report_maintenance->idClient)
            ->select(['name'])
            ->pluck('name')
            ->first();

        User::where('userTypeID',$report_maintenance->id_tecnichal)
            ->where('userType',3)
            ->select(['id','name','userTypeID'])
            ->first();

        $answerDevices=AnswerDeviceMain::where('idClient',$auxClientId)
            ->where('idReportMain','=',$id)
            ->get();

        $count=0;

        foreach ($answerDevices as $device)
        {
            $count++;
            $device->index=$count;
        }

        return view('frontoffice.reportMaintenanceShow',compact('report_maintenance','id','answerDevices','device'));
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
            ->select(['id','name','userTypeID'])
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

        $report_punctual=new ReportPunctual;
        $report_punctual->specie=$inputs['specie'];
        $report_punctual->note=$inputs['note'];
        $report_punctual->sub_active=$inputs['subs_active'];
        $report_punctual->action=$inputs['action'];
        $report_punctual->idClient=$auxClientId;
        $report_punctual->numberVisit=$visitNumber;
        $report_punctual->id_tecnichal=$technicalInfo->userTypeID;
        $report_punctual->save();

        return redirect('/frontoffice/documents/Controlopragas');
    }

    public function reportPunctualShow($idReport)
    {
        $auxClientId = Session::get('clientImpersonatedId');

        $report_punctual = ReportPunctual::where('id',$idReport)
            ->where('idClient',$auxClientId)->first();

        $report_punctual->technicalName= User::where('userTypeID',$report_punctual->id_tecnichal)
            ->where('userType',3)
            ->select(['name'])
            ->pluck('name')
            ->first();
        $report_punctual->clientName=Customer::where('id',$report_punctual->idClient)
            ->select(['name'])
            ->pluck('name')
            ->first();

        User::where('userTypeID',$report_punctual->id_tecnichal)
            ->where('userType',3)
            ->select(['id','name','userTypeID'])
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

    /*public function verifyCodeDeviceExist()*/

    public function warrantyPest()
    {
        $auxClientId = Session::get('clientImpersonatedId');

        $devices=Devices::where('idClient',$auxClientId)->get();
        $count=0;

        /*$abc=Devices::where('idClient',$auxClientId)
            ->where('status','!=',null)
            ->get();*/
        $client=Customer::where('id',$auxClientId)
            ->select(['ownerID'])
            ->first();

        foreach ($devices as $device)
        {
            $count++;
            $device->index=$count;
        }

        return view ('frontoffice.warrantyPest',compact('devices','client'));
    }
    
    public function saveWarrantyPest(Request $request)
    {
        $inputs = $request->all();

        $auxClientId = Session::get('clientImpersonatedId');
        $auxTechnical = Session::get('impersonated');

        $technicalInfo = User::where('id',$auxTechnical)
            ->select(['id','name','userTypeID'])
            ->first();

        $countVisits= ReportWarranty::where('idClient',$auxClientId)
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
        $report_WarrantyPest->note=$inputs['note'];
        $report_WarrantyPest->idClient=$auxClientId;
        $report_WarrantyPest->numberVisit=$visitNumber;
        $report_WarrantyPest->id_tecnichal=$technicalInfo->userTypeID;
        $report_WarrantyPest->save();

        $answerDevices= AnswerDeviceWarranty::where('idClient',$auxClientId)
            ->where('idReportWarranty','=',0)
            ->get();

        foreach ($answerDevices as $answerDevice)
        {
            $answerDevice->idReportWarranty=$report_WarrantyPest->id;
            $answerDevice->save();
        }

        $devices=Devices::where('idClient',$auxClientId)->get();
        foreach ($devices as $device)
        {
            $device->controlWarranty=null;
            $device->save();
        }

        return redirect('/frontoffice/documents/Controlopragas');
    }

    public function reportWarrantyShow($id)
    {
        $auxClientId = Session::get('clientImpersonatedId');

        $report_warranty = ReportWarranty::where('id',$id)
            ->where('idClient',$auxClientId)->first();

        $report_warranty->technicalName= User::where('userTypeID',$report_warranty->id_tecnichal)
            ->where('userType',3)
            ->select(['name'])
            ->pluck('name')
            ->first();
        $report_warranty->clientName=Customer::where('id',$report_warranty->idClient)
            ->select(['name'])
            ->pluck('name')
            ->first();

        User::where('userTypeID',$report_warranty->id_tecnichal)
            ->where('userType',3)
            ->select(['id','name','userTypeID'])
            ->first();

        $answerDevices=AnswerDeviceWarranty::where('idClient',$auxClientId)
            ->where('idReportWarranty','=',$id)
            ->get();

        $count=0;

        foreach ($answerDevices as $device)
        {
            $count++;
            $device->index=$count;
        }

        return view('frontoffice.reportWarrantyShow',compact('report_warranty','id','answerDevices','device'));
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
        $auxClientId = Session::get('clientImpersonatedId');

        $device = Devices::where('id',$id)
            ->select(['number_device','cod_device','specie','isco'])
            ->first();

        $inputs = $request->all();

        $answer_device=new AnswerDeviceWarranty();
        $answer_device->status=$inputs['device_status'];
        $answer_device->idClient=$auxClientId;
        $answer_device->number_device=$device->number_device;
        $answer_device->cod_device=$device->cod_device;
        $answer_device->specie=$device->specie;
        $answer_device->isco=$device->isco;
        $answer_device->id_device=$id;
        $answer_device->save();

        if($answer_device->status=='em falta')
        {
            $answer_device=Devices::where('id','=', $id)->delete();
        }

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

        $auxTechnical = Session::get('impersonated');

        $punctual_data=new ReportPunctualData();
        $punctual_data->name=$inputs['name'];
        $punctual_data->address=$inputs['address'];
        $punctual_data->nif=$inputs['nif'];
        $punctual_data->value=$inputs['value'];
        $punctual_data->specie=$inputs['specie'];
        $punctual_data->note=$inputs['note'];
        $punctual_data->sub_active=$inputs['subs_active'];
        $punctual_data->action=$inputs['action'];
        /*$punctual_data->id_tecnichal=$technicalInfo->userTypeID;*/
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

        if(Hash::check($pin, $pinClient->pin)) {
           return 1;
        }else
            return 0;
    }
}