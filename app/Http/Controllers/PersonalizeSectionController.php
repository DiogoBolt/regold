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
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class PersonalizeSectionController extends Controller
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

    public function getSection(){
        $auxClientId = Session::has('clientImpersonatedId') ? Session::get('clientImpersonatedId') : Session::get('establismentID');

        /*$activityTypeId=Customer::where('id',$auxClientId)
        ->select(['activity'])
        ->pluck('activity')->first();*/

        $sections=Section::all();

        $clientSections=ClientSection::where('id_client',$auxClientId)
        ->where('active',1)
        ->select([
            'id',
            'id_section',
            'designation',
            'active'
        ])->get();

        $control = ControlCustomizationClients::where('idClient',$auxClientId)->first();

        $index=[];

        if($control->personalizeSections==1){
            foreach($sections as $section){

                for($i=0; $i<count($clientSections); $i++){
                    $auxName=$section->name."1";
                    if($auxName==$clientSections[$i]->designation){
                        $section->checked=1;

                        array_push($index,$i);
                        break;
                    }else{
                        $section->checked=0;
                    }
                }
            }
            for($i=0;$i<count($index);$i++){
                unset($clientSections[$index[$i]]);
            }
        }else{
            foreach($sections as $section){
                $section->checked=0;
            }
        }

        foreach($sections as $section)
        {
            $section->idClientSection = ClientSection::where('id_client',$auxClientId)->where('id_section',$section->id)->first() ? ClientSection::where('id_client',$auxClientId)->where('id_section',$section->id)->first()->id : 0;
        }

        return view('frontoffice.personalizeSections',compact('sections','clientSections','control'));
    }

    public function saveClientSection(Request $request){
        $inputs = $request->all();
        $sections = json_decode($inputs['sections']);

        $auxClientId = Session::get('clientImpersonatedId');

        $sectionsClient = ClientSection::where('id_client',$auxClientId)
        /*->where('active',1)*/
        ->select(['id','active'])
        ->get();

        $indexs=[];
        
        foreach($sectionsClient as $sectionClient){
            $exist=false;

            foreach($sections as $section){
                if($sectionClient->id == $section->idClientSection){
                   $exist=true;
                   break;
                }
            }
            if(!$exist){
                array_push($indexs,$sectionClient->id);
            }
        }

        if(count($indexs)>0){
            foreach($indexs as $index){
                $clientSectionChange= ClientSection::where('id',$index)->first();
                $clientSectionChange->active=0;
                $clientSectionChange->save();
            }
        }

        foreach($sections as $section){

            if($section->idClientSection==0){
                if($section->activityClientId==1)
                {
                    $sectionClient = new ClientSection;
                    $sectionClient->id_client=$auxClientId;
                    $sectionClient->id_section=$section->sectionId;
                    $sectionClient->hygieneSection=0;
                    $sectionClient->designation=$section->designation;
                    $sectionClient->active=1;
                    $sectionClient->save();
                }else{
                    $sectionClient = new ClientSection;
                    $sectionClient->id_client=$auxClientId;
                    $sectionClient->id_section=$section->sectionId;
                    $sectionClient->hygieneSection=1;
                    $sectionClient->designation=$section->designation;
                    $sectionClient->active=1;
                    $sectionClient->save();
                }
            }else{
                $clientSectionChange= ClientSection::where('id_section',$section->sectionId)->where('id_client',$auxClientId)->where('active',0)->first();
                if($clientSectionChange!=null){
                    $clientSectionChange->active=1;
                    $clientSectionChange->save();
                }

            }
        }
        $control= ControlCustomizationClients::where('idClient',$auxClientId)->first();
        $control->personalizeSections=1;
        $control->save();
    }
    

    public function getAreasEquipments(){
    
        $auxClientId = Session::get('clientImpersonatedId');

        $clientSections=ClientSection::where('id_client',$auxClientId)
        ->where('active',1)
        ->select([
            'id',
            'id_section',
            'designation',
            'wasPersonalized',
        ])->get();

        return view('frontoffice.personalizeAreasEquipments',compact('clientSections'));
    }

    public function personalizeEachSection($id){
        $clientSection = ClientSection::where('id',$id)
        ->select([
            'id',
            'id_section',
            'designation',
            'wasPersonalized',
        ])->first();

        $areas = Area::where('idSection',$clientSection->id_section)
        ->orWhere('idSection',0)
        ->get();

        $equipments = Equipment::where('idSection',$clientSection->id_section)
        ->orWhere('idSection',0)
        ->get();
        
        $areasSectionClients=AreaSectionClient::where('idSection', $clientSection->id)
        ->where('active',1)
        ->get();

        $equipmentsSectionClient=EquipmentSectionClient::where('idSection', $clientSection->id)
            ->where('active',1)->get();
        
        $indexAreas=[];
        $indexEquipments=[];

        if($clientSection->wasPersonalized == 1){
            foreach($areas as $area){
                for($i=0; $i<count($areasSectionClients); $i++){
                    $auxName=$area->designation;
                    if($auxName==$areasSectionClients[$i]->designation){
                        $area->checked=1;
                        $area->idAreaSectionClient=$areasSectionClients[$i]->id;
                        $area->idFrequencyCleaning=$areasSectionClients[$i]->idFrequencyCleaning;
                        $area->idProduct=$areasSectionClients[$i]->idProduct;
                        array_push($indexAreas,$i);
                        break;
                    }else{
                        $area->idAreaSectionClient=0;
                        $area->checked=0;
                    }
                }
            }
            foreach($equipments as $equipment){
                for($i=0; $i<count($equipmentsSectionClient); $i++){
                    $auxName=$equipment->designation;
                    if($auxName==$equipmentsSectionClient[$i]->designation){
                        $equipment->checked=1;
                        $equipment->idAreaSectionClient=$equipmentsSectionClient[$i]->id;
                        $equipment->idFrequencyCleaning=$areasSectionClients[$i]->idFrequencyCleaning;
                        $equipment->idProduct=$areasSectionClients[$i]->idProduct;
                        array_push($indexEquipments,$i);
                        break;
                    }else{
                        $equipment->checked=0;
                        $equipment->idAreaSectionClient=0;
                    }
                }
            }
          
            for($i=0;$i<count($indexAreas);$i++){
                unset($areasSectionClients[$indexAreas[$i]]);
            }
            for($i=0;$i<count($indexEquipments);$i++){
                unset($equipmentsSectionClient[$indexEquipments[$i]]);
            }

        }else{
            foreach($areas as $area){
                $area->checked=1;
                $area->idAreaSectionClient=0;

            }
            foreach($equipments as $equipment){
                $equipment->checked=1;
                $equipment->idAreaSectionClient=0;
            }
        }

        $lastArea=AreaSectionClient::orderBy('id', 'desc')->take(1)->first()->id;
        $lastEquipment=EquipmentSectionClient::orderBy('id', 'desc')->take(1)->first()->id;

        $products = Product::whereNotIn('category',array(6,16,20))
        ->select([
                'id',
                'name',
            ])->get();

        $cleaningFrequencys = CleanFrequency::select([
            'id',
            'designation',
        ])->get();


        return view('frontoffice.personalizeEachSection',compact('clientSection','areas','areasSectionClients','equipments','equipmentsSectionClient','products','cleaningFrequencys','lastArea','lastEquipment'));
    }

    public function saveEachSection(Request $request){
        $inputs = $request->all();

        $areas = json_decode($inputs['areas']);
        $equipments = json_decode($inputs['equipments']);
        $idSection = json_decode($inputs['idSection']);

        $auxClientId = Session::get('clientImpersonatedId');

        $areasSectionClient = AreaSectionClient::where('idClient', $auxClientId)
        ->where('idSection',$idSection)
        ->select(['id',])
        ->get();

        $indexsAreas=[];
        
        foreach($areasSectionClient as $areaSectionClient){
            $exist=false;
            foreach($areas as $area){
                if($areaSectionClient->id == $area->idAreaSectionClient){
                   $exist=true;
                   break;
                }
            }
            if(!$exist){
                array_push($indexsAreas,$areaSectionClient->id);
            }
        }

        foreach($indexsAreas as $indexAreas){
            $areasSectionClientActive= AreaSectionClient::where('id',$indexAreas)->first();
            $areasSectionClientActive->active=0;
            $areasSectionClientActive->save();
        }

        foreach($areas as $area){
            if($area->idAreaSectionClient==0){
                $AreaSectionClient = new AreaSectionClient;
                $AreaSectionClient->idClient=$auxClientId;
                $AreaSectionClient->idSection=$idSection;
                $AreaSectionClient->designation=$area->designation;
                $AreaSectionClient->idCleaningFrequency=$area->idCleaningFrequency;
                $AreaSectionClient->idProduct=$area->idProduct;
                $AreaSectionClient->active=1;
                $AreaSectionClient->save();
            }else{
                $AreaSectionClient =AreaSectionClient::where('id',$area->idAreaSectionClient)->first();
                $AreaSectionClient->designation=$area->designation;
                $AreaSectionClient->idCleaningFrequency=$area->idCleaningFrequency;
                $AreaSectionClient->idProduct=$area->idProduct;
                $AreaSectionClient->save();
            }
        }

        $equipmentsSectionClient = EquipmentSectionClient::where('idClient', $auxClientId)
            ->where('idSection',$idSection)
        ->select(['id',])
        ->get();

        $indexsEquipment=[];
        
        foreach($equipmentsSectionClient as $equipmentSectionClient){
            $exist=false;
            foreach($equipments as $equipment){
                if($equipmentSectionClient->id == $equipment->idAreaSectionClient){
                   $exist=true;
                   break;
                }
            }
            if(!$exist){
                array_push($indexsEquipment,$equipmentSectionClient->id);
            }
        }
        
        foreach($indexsEquipment as $indexEquipment){
            $equipmentsSectionClient= EquipmentSectionClient::where('id',$indexEquipment)->first();
            $equipmentsSectionClient->active=0;
            $equipmentsSectionClient->save();

        }
        
        foreach($equipments as $equipment){
            if($equipment->idAreaSectionClient==0){
                $EquipmentSectionClient = new EquipmentSectionClient;
                $EquipmentSectionClient->idClient=$auxClientId;
                $EquipmentSectionClient->idSection=$idSection;
                $EquipmentSectionClient->designation=$equipment->designation;
                $EquipmentSectionClient->idCleaningFrequency=$equipment->idCleaningFrequency;
                $EquipmentSectionClient->idProduct=$equipment->idProduct;
                $EquipmentSectionClient->active=1;
                $EquipmentSectionClient->save();
            }else{
                $EquipmentSectionClient =EquipmentSectionClient::where('id',$equipment->idAreaSectionClient)->first();
                $EquipmentSectionClient->designation=$equipment->designation;
                $EquipmentSectionClient->idCleaningFrequency=$equipment->idCleaningFrequency;
                $EquipmentSectionClient->idProduct=$equipment->idProduct;
                $EquipmentSectionClient->active=1;
                $EquipmentSectionClient->save();
            }
        }

        $clientSection = ClientSection::where('id',$idSection)->first();
        $clientSection->wasPersonalized=1;
        $clientSection->save();
    }

    public function getAllProduct(){
        $products = Product::select([
            'id',
            'name',
        ])->get();
        
        return $products;
    }

    public function getAllCleanFrequency(){
        $cleaningFrequencys = CleanFrequency::select([
            'id',
            'designation',
        ])->get();

        return $cleaningFrequencys;
    }

}