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
        $auxClientId = Session::get('clientImpersonatedId');
        $sections=Section::select(['id','name',
        ])->get();

        $clientSections=ClientSection::where('id_client',$auxClientId)
        ->select([
            'id',
            'id_section',
            'designation',
        ])->get();

        $control= ControlCustomizationClients::where('idClient',$auxClientId)->first();
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
        }
        return view('frontoffice.personalizeSections',compact('sections','clientSections','control'));
    }

    public function saveClientSection(Request $request){
        $inputs = $request->all();
        $sections = json_decode($inputs['sections']);
        $auxClientId = Session::get('clientImpersonatedId');

        $sectionClient = ClientSection::where('id_client', $auxClientId)->delete();

        foreach($sections as $section){
            $sectionClient = new ClientSection;
            $sectionClient->id_client=$auxClientId;
            $sectionClient->id_section=$section->sectionId;
            $sectionClient->designation=$section->designation;
            $sectionClient->save();
        }

        $control= ControlCustomizationClients::where('idClient',$auxClientId)->first();
        $control->personalizeSections=1;
        $control->save();
    }

    public function getAreasEquipments(){
    
        $auxClientId = Session::get('clientImpersonatedId');

        $clientSections=ClientSection::where('id_client',$auxClientId)
        ->select([
            'id',
            'id_section',
            'designation',
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
        
        $areasSectionClients= AreaSectionClient::where('idSection', $clientSection->id)->get();
        
        $index=[];
        if($clientSection->wasPersonalized == 1){
            foreach($areas as $area){
                for($i=0; $i<count($areasSectionClients); $i++){
                    $auxName=$area->designation;
                    if($auxName==$areasSectionClients[$i]->designation){
                        $area->checked=1;
                        array_push($index,$i);
                        break;
                    }else{
                        $area->checked=0;
                    }
                }
            }
            for($i=0;$i<count($index);$i++){
                unset($areasSectionClients[$index[$i]]);
            }
        }
        //dd($areas);
     
        $equipments = Equipment::where('idSection',$clientSection->id_section)
        ->orWhere('idSection',0)
        ->get();

        $products = Product::select([
            'id',
            'name',
        ])->get();

        $cleaningFrequencys = CleanFrequency::select([
            'id',
            'designation',
        ])->get();

        return view('frontoffice.personalizeEachSection',compact('clientSection','areas','equipments','products','cleaningFrequencys'));
    }

    public function saveEachSection(Request $request){
        $inputs = $request->all();
        
        $areas = json_decode($inputs['areas']);
        $idSection = json_decode($inputs['idSection']);

        $auxClientId = Session::get('clientImpersonatedId');

        $AreasSectionClient = AreaSectionClient::where('idClient', $auxClientId)->delete();
        
        foreach($areas as $area){
            $AreaSectionClient = new AreaSectionClient;
            $AreaSectionClient->idClient=$auxClientId;
            $AreaSectionClient->idSection=$idSection;
            $AreaSectionClient->designation=$area->designation;
            $AreaSectionClient->idCleaningFrequency=$area->idCleaningFrequency;
            $AreaSectionClient->idProduto=$area->idProduto;
            $AreaSectionClient->save();
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