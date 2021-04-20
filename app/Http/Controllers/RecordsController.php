<?php
namespace App\Http\Controllers;

use App\AreaSectionClient;
use App\CleaningFrequency;
use App\ClientInsertProducts;
use App\ClientProviders;
use App\ClientSection;
use App\ClientThermo;
use App\EquipmentSectionClient;
use App\FridgeType;
use App\HygieneRecords;
use App\OilRecord;
use App\Product;
use App\ProductRecords;
use App\Thermo;
use App\ThermoAverageTemperature;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class RecordsController extends Controller
{
    private $months = [
        1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril', 5 => 'Maio',
        6 => 'Junho', 7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro', 10 => 'Outubro',
        11 => 'Novembro', 12 => 'Dezembro'
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

////////////REGISTOS DO ESTADO DO OLEO///////////////////////////////////////////////////////////////////

    public function insertOilRecords()
    {
        $today = Carbon::now()->format('Y-m-d');

        return view('frontoffice.oilRecords',compact('today'));
    }
    public function saveOilRecords(Request $request)
    {
        $user = Auth::user();

        $auxClientId = Session::has('clientImpersonatedId') ? Session::get('clientImpersonatedId') : Session::get('establismentID');

        $inputs = $request->all();
        $oil_records= new OilRecord();
        $oil_records->record_date= $inputs['record_date'];
        $oil_records->oil_aspect= $inputs['oilAspect'];
        $oil_records->equipment_name=$inputs['equipment_name'];
        $oil_records->equipment_number=$inputs['equipment_number'];
        $oil_records->client_id = $auxClientId;
        if(isset($inputs['trocaOleo'])==0) $oil_records->changeOil = 0; else $oil_records->changeOil =$inputs['trocaOleo'];
        $oil_records->save();

        return redirect('/frontoffice/records/oil')->with('message','Registo realizado com sucesso!');
    }
    public function getOilRecordsHistory()
    {
        $auxClientId = Session::has('clientImpersonatedId') ? Session::get('clientImpersonatedId') : Session::get('establismentID');;

        $months = $this->months;

        $years = OilRecord::query()
            ->select([
                DB::raw('YEAR(created_at) as year')
            ])
            ->where('client_id', $auxClientId)
            ->groupBy('year')
            ->get();

        return view('frontoffice.oilRecordsHistory', compact([ 'years','months']));
    }
    public function getHistByMonth(Request $request)
    {
        $auxClientId = Session::has('clientImpersonatedId') ? Session::get('clientImpersonatedId') : Session::get('establismentID');;
        $date = Carbon::createFromDate($request->get('year'), $request->get('month'));
        $start_month = $date->copy()->startOfMonth();
        $end_month = $date->copy()->endOfMonth();

        return OilRecord::query()->select([
            'id', 'client_id', 'oil_aspect','changeOil','equipment_name','equipment_number', DB::raw('DAY(updated_at) as day')
        ])
            ->where('client_id',$auxClientId)
            ->whereBetween('updated_at', [$start_month, $end_month])
            ->orderBy('updated_at', 'asc')
            ->get();
    }
    public function printReportOil(Request $request)
    {
        $print_data = json_decode($request->get('printReport')[0]);
        return view('frontoffice.printOilReport')->with(['details' => $print_data[0] , 'data' => $print_data[1]]);
    }

/////////////////////////REGISTOS DE ENTRADA DE PRODUTO/////////////////////////////////////////////////////////////////////////

    public function insertRecords()
    {

        $auxClientId = Session::has('clientImpersonatedId') ? Session::get('clientImpersonatedId') : Session::get('establismentID');
        $client_insertProducts=ClientInsertProducts::where('client_id', $auxClientId)->get();
        $client_providers=ClientProviders::where('client_id', $auxClientId)->get();
        $today = Carbon::now()->format('Y-m-d');
        return view('frontoffice.insertProductConformities',compact('today','client_insertProducts','client_providers'));
    }
    public function saveInsertRecords(Request $request){

        $user = Auth::user();
        $auxClientId = Session::has('clientImpersonatedId') ? Session::get('clientImpersonatedId') : Session::get('establismentID');;

        $inputs = $request->all();
        $product_records= new ProductRecords();

        $existProduct=ClientInsertProducts::Where('client_id',$auxClientId)
            ->where('name',$inputs['product'])
            ->count();

        if($existProduct==0)
        {
            $client_insertProducts= new ClientInsertProducts();
            $client_insertProducts->client_id=$auxClientId;
            $client_insertProducts->name=$inputs['product'];
            $client_insertProducts->save();
            $product_records->product= $inputs['product'];
        }else{
            $product_records->product= $inputs['product'];
        }

        $existProvider=ClientProviders::Where('client_id',$auxClientId)
            ->where('name',$inputs['provid'])
            ->count();

        if($existProvider==0)
        {
            $client_providers= new ClientProviders();
            $client_providers->client_id=$auxClientId;
            $client_providers->name=$inputs['provid'];
            $client_providers->save();
            $product_records->provider= $inputs['provid'];
        }else{
            $product_records->provider= $inputs['provid'];
        }

        if($request->hasfile('image'))
        {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename =time().'.'.$extension;
            $file->move('uploads/records/', $filename);
            $product_records->image=$filename;
        }
        $product_records->fatura_guia=$inputs['fatura'];
        $product_records->date=$inputs['date'];
        $product_records->temperature= $inputs['temperature'];
        $product_records->cleaning= $inputs['cleaning'];
        $product_records->product_status= $inputs['product_status'];
        $product_records->package= $inputs['package'];
        $product_records->observations=$inputs['obsTemperature'].''.$inputs['obsClean'].''.$inputs['obsStatus'].''.$inputs['obsLabel'].''.($inputs['obsPackage']);
        $product_records->label= $inputs['label'];
        $product_records->client_id = $auxClientId;
        $product_records->save();


        return redirect('/frontoffice/records/insertProduct')->with('message','Registo realizado com sucesso!');
    }

    function getInsertRecords()
    {
        $auxClientId = Session::has('clientImpersonatedId') ? Session::get('clientImpersonatedId') : Session::get('establismentID');;
        $months = $this->months;

        $clientProducts = ProductRecords::query()->select(['id', 'date', 'product','provider','temperature','cleaning','product_status','package','label','observations','image', DB::raw('DAY(updated_at) as day'),
        ])
            ->where('client_id', $auxClientId)
            ->groupBy('id')
            ->get();

        $years = ProductRecords::query()
            ->select([
                DB::raw('YEAR(created_at) as year')
            ])
            ->where('client_id', $auxClientId)
            ->groupBy('year')
            ->get();

        return view('frontoffice.insertProductRecordsHistory', compact('clientProducts','years','months'));
    }

    function getInsertProductByMonth(Request $request){

        $auxClientId = Session::has('clientImpersonatedId') ? Session::get('clientImpersonatedId') : Session::get('establismentID');;
        $date = Carbon::createFromDate($request->get('year'), $request->get('month'));
        $start_month = $date->copy()->startOfMonth();
        $end_month = $date->copy()->endOfMonth();

        return ProductRecords::query()->select([
            'id', 'date', 'product','provider','fatura_guia','temperature','cleaning','product_status','package','label','observations','image' ,DB::raw('DAY(updated_at) as day'),
        ])
            ->where('client_id',$auxClientId)
            ->whereBetween('updated_at', [$start_month, $end_month])
            ->orderBy('updated_at', 'asc')
            ->get();
    }
    public function printReportProducts(Request $request)
    {
        $print_data = json_decode($request->get('printReport')[0]);
        return view('frontoffice.printProductRecordsReport')->with(['details' => $print_data[0] , 'data' => $print_data[1]]);
    }

///////////////////////////REGISTOS DE HIGIENE//////////////////////////////////////////////////////////

    public function getHygieneRecords()
    {
        $auxClientId = Session::has('clientImpersonatedId') ? Session::get('clientImpersonatedId') : Session::get('establismentID');;

        $products=Product::all();

        $clientSections=ClientSection::where('id_client',$auxClientId)->where('active',1)->get();

        $ids = [];

        foreach ($clientSections as $clientSection){
            array_push($ids,$clientSection->id);
        }

            $areasDaily = AreaSectionClient::whereIN('idSection',$ids)
                ->Where(function($query) {
                    $query->where('idCleaningFrequency',1)
                        ->orwhere('idCleaningFrequency2',1)
                        ->orwhere('idCleaningFrequency3',1);
                })
                ->WhereDoesntHave('hygieneRecord',function ($query){
                    $query->where('created_at','>',Carbon::today())
                        ->where('idCleaningFrequency',1);
                })
                ->orderBy('idSection')
                ->get();

            foreach ($areasDaily as $areaDaily){
                if($areaDaily->idCleaningFrequency == 1){
                    $areaDaily->productId=$areaDaily->idProduct;
                }
                if($areaDaily->idCleaningFrequency2 == 1){
                    $areaDaily->productId=$areaDaily->idProduct2;
                }
                if($areaDaily->idCleaningFrequency3 == 1){
                    $areaDaily->productId=$areaDaily->idProduct3;
                }
            }

            $equipDaily = EquipmentSectionClient::whereIN('idSection',$ids)
                ->Where(function($query) {
                    $query->where('idCleaningFrequency',1)
                        ->orwhere('idCleaningFrequency2',1)
                        ->orwhere('idCleaningFrequency3',1);
                })
                ->WhereDoesntHave('hygieneRecordE',function ($query){
                    $query->where('created_at','>',Carbon::today())
                        ->where('idCleaningFrequency',1);
                })
                ->orderBy('idSection')
                ->get();

            foreach ($equipDaily as $equipD){
                if($equipD->idCleaningFrequency == 1){
                    $equipD->productId=$equipD->idProduct;
                }
                if($equipD->idCleaningFrequency2 == 1){
                    $equipD->productId=$equipD->idProduct2;
                }
                if($equipD->idCleaningFrequency3 == 1){
                    $equipD->productId=$equipD->idProduct3;
                }
            }

        $today = Carbon::now()->format('Y-m-d');

        return view('frontoffice.hygieneRegister', compact('today','clientSections','sections','areasMonthly','areasBiweekly','areasWeekly','areasDaily','equipDaily','equipWeekly','equipBiweekly','equipMonthly','products'));
    }

    public function getByFrequency($id){

        $auxClientId = Session::has('clientImpersonatedId') ? Session::get('clientImpersonatedId') : Session::get('establismentID');;

        $clientSections=ClientSection::where('id_client',$auxClientId)->where('active',1)->get();

        $ids = [];

        foreach ($clientSections as $clientSection){
            array_push($ids,$clientSection->id);
        }

            $itemsA = AreaSectionClient::whereIN('idSection',$ids)
                ->Where(function($query) use ($id) {
                    $query->where('idCleaningFrequency',$id)
                        ->orwhere('idCleaningFrequency2',$id)
                        ->orwhere('idCleaningFrequency3',$id);
                })
                ->WhereDoesntHave('hygieneRecord',function ($query) use ($id){
                    $query->where('created_at','>',Carbon::today())
                        ->where('idCleaningFrequency',$id);
                })
                ->orderBy('idSection')
                ->get();

            $itemsE = EquipmentSectionClient::whereIN('idSection',$ids)
                ->Where(function($query) use ($id) {
                    $query->where('idCleaningFrequency',$id)
                        ->orwhere('idCleaningFrequency2',$id)
                        ->orwhere('idCleaningFrequency3',$id);
                })
                ->WhereDoesntHave('hygieneRecordE',function ($query) use ($id){
                    $query->where('created_at','>',Carbon::today())
                        ->where('idCleaningFrequency', $id);
                })
                ->orderBy('idSection')
                ->get();

        foreach ($itemsA as $item){
            if($item->idCleaningFrequency == $id){
                $item->productId=$item->idProduct;
            }
            if($item->idCleaningFrequency2 == $id){
                $item->productId=$item->idProduct2;
            }
            if($item->idCleaningFrequency3 == $id){
                $item->productId=$item->idProduct3;
            }
            $item->sectionDesignation = ClientSection::where('id',$item->idSection)->first()->designation;
            $item->productName = Product::where('id',$item->productId)->first()->name;
        }

        foreach ($itemsE as $item){
            if($item->idCleaningFrequency == $id){
                $item->productId=$item->idProduct;
            }
            if($item->idCleaningFrequency2 == $id){
                $item->productId=$item->idProduct2;
            }
            if($item->idCleaningFrequency3 == $id){
                $item->productId=$item->idProduct3;
            }
            $item->sectionDesignation = ClientSection::where('id',$item->idSection)->first()->designation;
            $item->productName = Product::where('id',$item->productId)->first()->name;
        }

        return [$itemsA,$itemsE];
    }

    public function saveHygieneRecords(Request $request)
    {
        $user = Auth::user();

        $auxClientId = Session::has('clientImpersonatedId') ? Session::get('clientImpersonatedId') : Session::get('establismentID');;

        $inputs = $request->all();

        $checkboxes = json_decode($inputs['checkBoxes']);

        foreach ($checkboxes as $checkbox)
        {
            $recordsHygiene = new HygieneRecords();
            $recordsHygiene->idClient=$auxClientId;
            if(isset($checkbox->idArea)) $recordsHygiene->idArea=$checkbox->idArea; else $recordsHygiene->idArea=0;
            if(isset($checkbox->idEquipment)) $recordsHygiene->idEquipment=$checkbox->idEquipment; else $recordsHygiene->idEquipment=0;
            $recordsHygiene->idProduct=$checkbox->idProduct;
            $recordsHygiene->designation=$checkbox->designation;
            $recordsHygiene->idCleaningFrequency=$checkbox->idCleaningFrequency;
            $recordsHygiene->idSection=$checkbox->idSection;
            $recordsHygiene->save();
        }
    }
    function getHygieneRecordsHistory()
    {
        $auxClientId = Session::has('clientImpersonatedId') ? Session::get('clientImpersonatedId') : Session::get('establismentID');;
        $months = $this->months;

        $years = HygieneRecords::query()
            ->select([
                DB::raw('YEAR(created_at) as year')
            ])
            ->where('idClient', $auxClientId)
            ->groupBy('year')
            ->get();


        $cleaningFrequency=CleaningFrequency::query()->select(['id','designation'])
            ->get();

        $clientSections = ClientSection::where('id_client',$auxClientId)->where('active',1)->get();

        return view('frontoffice.hygieneRecordsHistory', compact(['years','months','cleaningFrequency','clientSections','is']));
    }
    function getHygieneByMonth(Request $request){
        $auxClientId = Session::has('clientImpersonatedId') ? Session::get('clientImpersonatedId') : Session::get('establismentID');;
        $date = Carbon::createFromDate($request->get('year'), $request->get('month'));
        $start_month = $date->copy()->startOfMonth();
        $end_month = $date->copy()->endOfMonth();
        $cleaningFrequency = $request->get('cleaningFrequency');
        $clientSection = $request->get('clientSection');

        /*$nDays=cal_days_in_month (  CAL_GREGORIAN,$request->get('month'), $request->get('year') );*/

        //aqui vou buscar as areas do cliente

        $areas = AreaSectionClient::where('idSection',$clientSection)
            ->Where(function($query) use ($cleaningFrequency) {
                $query->where('idCleaningFrequency',$cleaningFrequency)
                    ->orwhere('idCleaningFrequency2',$cleaningFrequency)
                    ->orwhere('idCleaningFrequency3',$cleaningFrequency);
            })
            ->select(['id','designation'])
            ->get();

        $equipments = EquipmentSectionClient::where('idSection',$clientSection)
            ->Where(function($query) use ($cleaningFrequency) {
                $query->where('idCleaningFrequency',$cleaningFrequency)
                    ->orwhere('idCleaningFrequency2',$cleaningFrequency)
                    ->orwhere('idCleaningFrequency3',$cleaningFrequency);
            })
            ->select(['id','designation'])
            ->get();


        foreach ($areas as $area){

            //aqui vou buscar os registos de higiene da area, ou seja trago os registo se foi limpo

            $area->hygiene = HygieneRecords::where('idArea',$area->id)
                ->where('idCleaningFrequency',$cleaningFrequency)
                ->whereBetween('created_at', [$start_month, $end_month])
                ->select([DB::raw('DAY(created_at) as day')])
                ->get();
        }
        foreach ($equipments as $equipment){

            $equipment->hygiene = HygieneRecords::where('idArea',$area->id)
                ->where('idCleaningFrequency',$cleaningFrequency)
                ->whereBetween('created_at', [$start_month, $end_month])
                ->select([DB::raw('DAY(created_at) as day')])
                ->get();
        }


        /*foreach ($equipments as $equipment){

            $equipment->hygiene = HygieneRecords::where('idEquipment',$equipment->id)
                ->where('idCleaningFrequency',$cleaningFrequency)
                ->whereBetween('created_at', [$start_month, $end_month])
                ->select([DB::raw('DAY(created_at) as day')])
                ->get();
        }*/

       /* $item=HygieneRecords::query()
            ->where('idClient',$auxClientId)
            ->where('idCleaningFrequency',$cleaningFrequency)
            ->where('idSection', $clientSection)
            ->whereBetween('updated_at', [$start_month, $end_month])
            ->select([
                'id', 'idClient', 'idArea','idEquipment','idProduct','idCleaningFrequency','designation','idSection',DB::raw('DAY(created_at) as day'), DB::raw('DAY(updated_at) as day')
            ])
            ->get();*/






        return response()->json($areas);
    }

    public function printRecordsHygiene(Request $request)
    {
        $print_data = json_decode($request->get('printReport')[0]);
        return view('frontoffice.printRecordsHygiene')->with(['details' => $print_data[0] , 'data' => $print_data[1]]);
    }

    public function getObservation($id,$type){

        if($type=='a')
        {
            $observation = AreaSectionClient::where('id',$id)->first()->observation;
        }else{
            $observation = EquipmentSectionClient::where('id',$id)->first()->observation;
        }

        return $observation;
    }

    ///////////REGISTOS DE TEMPERATURA//////////////////////////////////////////////////////////////////////

    public function getTemperatureRecords()
    {
        $user = Auth::user();

        $auxAdminId=Session::get('impersonated');

        if($auxAdminId==null)
        {
            $userType=4;
        }else{
            $userType=User::where('id',$auxAdminId)
                ->select(['userType'])
                ->pluck('userType')->first();
        }

        $clientThermos = ClientThermo::query()->where('user_id', Session::get('establismentID'))->get();

        foreach ($clientThermos as $clientthermo) {

            $clientthermo->thermo = Thermo::query()->where('imei', $clientthermo->imei)->get()->last();
            $clientthermo->fridgeType = FridgeType::query()->where('id', $clientthermo->type)->first();

            $average = ThermoAverageTemperature::query()
                ->where('client_thermo', $clientthermo->id)
                ->where('created_at','>',Carbon::now()->startOfDay())
                ->where('created_at','<',Carbon::now()->endOfDay())
                ->get()->last();
            $clientthermo->average = isset($average) ? $average : null;
            if(isset($clientthermo->thermo))
            {
                if($clientthermo->thermo->signal_power < 6) {
                    $clientthermo->signal_power = 1;
                }
                elseif($clientthermo->thermo->signal_power < 12) {
                    $clientthermo->signal_power = 2;
                }

                elseif($clientthermo->thermo->signal_power < 22) {
                    $clientthermo->signal_power = 3;
                }
                elseif($clientthermo->thermo->signal_power >= 22) {
                    $clientthermo->signal_power = 4;
                }
            }else{
                $clientthermo->signal_power = 1;
            }
        }

        $today = Carbon::now()->format('Y-m-d');

        return view('frontoffice.temperatureRegister', compact('today', 'clientThermos','userType'));
    }

    public function getTemperatureRecordsHistory()
    {
        $user = Auth::user();
        $months = $this->months;

        $clientThermos = ClientThermo::query()->select(['id', 'type', 'imei','number'])
            ->where('user_id', Session::get('establismentID'))
            ->groupBy('id')
            ->get();

        $years = ThermoAverageTemperature::query()
            ->select([
                DB::raw('YEAR(created_at) as year')
            ])
            ->where('user_id', Session::get('establismentID'))
            ->groupBy('year')
            ->get();

        return view('frontoffice.temperatureRegisterHistory', compact(['clientThermos', 'years', 'months']));
    }

    public function getHistoryByMonth(Request $request)
    {
        $date = Carbon::createFromDate($request->get('year'), $request->get('month'));
        $start_month = $date->copy()->startOfMonth();
        $end_month = $date->copy()->endOfMonth();
        $imei = $request->get('imei');

        return ThermoAverageTemperature::query()->select([
            'id', 'morning_temp', 'afternoon_temp', DB::raw('DAY(updated_at) as day'), 'observations'
        ])
            ->where('client_thermo', '=', $imei)
            ->whereBetween('updated_at', [$start_month, $end_month])
            ->orderBy('updated_at', 'asc')
            ->get();
    }

    public function saveComment(Request $request)
    {
        try {
            $comment = ThermoAverageTemperature::query()->findOrFail($request->get('id'));
            $comment->observations = $request->get('obs');
            $comment->save();

            return ['success' => 'Observação guardada com êxito.'];
        } catch (\Exception $exception) {
            return ['error' => 'Ocorreu um erro, por favor, tente mais tarde.'];
        }
    }

    public function printReport(Request $request)
    {
        $user = Auth::user();
        $print_data = json_decode($request->get('printReport')[0]);
        Mail::send('frontoffice.printTemperaturesReport', ['details' => $print_data[0] , 'data' => $print_data[1]], function ($m) use ($user) {
            $m->from('suporte@regolfood.pt', 'O Seu Relatório');

            $m->to($user->email)->subject('O Seu Relatório');
        });
        return view('frontoffice.printTemperaturesReport')->with(['details' => $print_data[0] , 'data' => $print_data[1]]);
    }

    public function getLast5Temperatures($id)
    {
        $imei = ClientThermo::where('id',$id)->first()->imei;
        $last5reads = Thermo::where('imei',$imei)->orderBy('id','DESC')->get()->take(5);

        return $last5reads;
    }

    public function editThermoTemperature(Request $request)
    {
        $inputs = $request->all();
        $thermo = ClientThermo::where('id',$inputs['idThermo'])->first();
        $daytime = $inputs['dayTime'];

        $average = ThermoAverageTemperature::where('client_thermo',$thermo->id)->where('created_at','>',Carbon::now()->startOfDay())->first();

        if($daytime == 'm')
        {
            if(isset($average))
            {
                $average->morning_temp = str_replace(',','.',$inputs['valor']);
                $average->save();
            }else{
                $average = new ThermoAverageTemperature;
                $average->client_thermo = $thermo->id;
                $average->user_id = Auth::user()->client_id;
                $average->morning_temp = str_replace(',','.',$inputs['valor']);
                $average->save();
            }
        }else{
            if(isset($average))
            {
                $average->afternoon_temp = str_replace(',','.',$inputs['valor']);
                $average->save();
            }else{
                $average = new ThermoAverageTemperature;
                $average->client_thermo = $thermo->id;
                $average->user_id = Auth::user()->client_id;
                $average->afternoon_temp = str_replace(',','.',$inputs['valor']);
                $average->save();
            }
        }
        return back();
    }

    public function editThermoName(Request $request)
    {
        $inputs = $request->all();
        $thermo = ClientThermo::where('id',$inputs['idThermo'])->first();

        $thermo->number = $request->filled('name') ? $inputs['name'] : $thermo->number;
        $thermo->imei = $request->filled('imei') ? $inputs['imei'] : $thermo->imei;
        $thermo->updateTimer = $request->filled('update') ? $inputs['update'] : $thermo->updateTimer;
        $thermo->save();

        return back();
    }

}