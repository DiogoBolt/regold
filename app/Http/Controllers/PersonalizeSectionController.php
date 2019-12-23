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

}