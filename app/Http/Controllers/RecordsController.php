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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $today = Carbon::now()->format('yy-m-d');

        return view('frontoffice.oilRecords',compact('today'));
    }
    public function saveOilRecords(Request $request)
    {
        $user = Auth::user();

        $auxClientId = Session::get('establismentID');

        $inputs = $request->all();
        $oil_records= new OilRecord();
        $oil_records->record_date= $inputs['record_date'];
        $oil_records->oil_aspect= $inputs['oilAspect'];
        $oil_records->equipment_name=$inputs['equipment_name'];
        $oil_records->equipment_number=$inputs['equipment_number'];
        $oil_records->client_id = $auxClientId;
        if(isset($inputs['trocaOleo'])==0) $oil_records->changeOil = 0; else $oil_records->changeOil =$inputs['trocaOleo'];
        $oil_records->save();

        return redirect('/frontoffice/documents/Registos');
    }
    public function getOilRecordsHistory()
    {
        $auxClientId = Session::get('clientImpersonatedId');
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
        $auxClientId = Session::get('clientImpersonatedId');
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
        $auxClientId = Session::get('establismentID');
        $client_insertProducts=ClientInsertProducts::where('client_id', $auxClientId)->get();
        $client_providers=ClientProviders::where('client_id', $auxClientId)->get();
        $today = Carbon::now()->format('yy-m-d');
        return view('frontoffice.insertProductConformities',compact('today','client_insertProducts','client_providers'));
    }
    public function saveInsertRecords(Request $request){

        $user = Auth::user();
        $auxClientId = Session::get('establismentID');

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
        $auxClientId = Session::get('clientImpersonatedId');
        $months = $this->months;

        $clientProducts = ProductRecords::query()->select(['id', 'date', 'product','provider','temperature','cleaning','product_status','package','label','observations', DB::raw('DAY(updated_at) as day'),
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

        $auxClientId = Session::get('establismentID');
        $date = Carbon::createFromDate($request->get('year'), $request->get('month'));
        $start_month = $date->copy()->startOfMonth();
        $end_month = $date->copy()->endOfMonth();

        return ProductRecords::query()->select([
            'id', 'date', 'product','provider','temperature','cleaning','product_status','package','label','observations' ,DB::raw('DAY(updated_at) as day'),
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
        $user = Auth::user();

        $sections = ClientSection::where('id_client',$user->client_id)->get();

        $products=Product::all();

        foreach($sections as $section)
        {
            $section->equipments = EquipmentSectionClient::where('idClient',$user->client_id)->get();
            $section->areas = AreaSectionClient::where('idClient',$user->client_id)->get();
        }

        $today = Carbon::now()->format('Y-m-d');

        $sections = ClientSection::where('id_client',$user->client_id)->get();


        return view('frontoffice.hygieneRegister', compact('today','sections','section','products'));
    }
    public function saveHygieneRecords(Request $request)
    {
        $user = Auth::user();

        $auxClientId = Session::get('establismentID');

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
            $recordsHygiene->checked=1;
            $recordsHygiene->save();
        }
    }
    function getHygieneRecordsHistory()
    {
        $auxClientId = Session::get('clientImpersonatedId');
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

        return view('frontoffice.hygieneRecordsHistory', compact(['years','months','cleaningFrequency']));
    }
    function getHygieneByMonth(Request $request){
        $auxClientId = Session::get('clientImpersonatedId');
        $date = Carbon::createFromDate($request->get('year'), $request->get('month'));
        $start_month = $date->copy()->startOfMonth();
        $end_month = $date->copy()->endOfMonth();
        $cleaningFrequency = $request->get('cleaningFrequency');

        $item=HygieneRecords::query()
            ->where('idClient',$auxClientId)
            ->where('idCleaningFrequency',$cleaningFrequency)
            ->whereBetween('updated_at', [$start_month, $end_month])
            ->select([
                'id', 'idClient', 'idArea','idEquipment','idProduct','idCleaningFrequency','designation','checked',DB::raw('DAY(created_at) as day'), DB::raw('DAY(updated_at) as day')
            ])
            ->orderBy('idArea', 'asc')
            ->orderBy('idEquipment','asc')
            ->get();

        return response()->json($item);
    }

    public function printRecordsHygiene(Request $request)
    {
        $print_data = json_decode($request->get('printReport')[0]);
        return view('frontoffice.printRecordsHygiene')->with(['details' => $print_data[0] , 'data' => $print_data[1]]);
    }

    ///////////REGISTOS DE TEMPERATURA//////////////////////////////////////////////////////////////////////

    public function getTemperatureRecords()
    {
        $user = Auth::user();

        $clientThermos = ClientThermo::query()->where('user_id', $user->id)->get();

        foreach ($clientThermos as $clientthermo) {

            $clientthermo->thermo = Thermo::query()->where('imei', $clientthermo->imei)->get()->last();
            $clientthermo->fridgeType = FridgeType::query()->where('id', $clientthermo->type)->first();
            $clientthermo->average = ThermoAverageTemperature::query()
                ->where('client_thermo', $clientthermo->id)
                ->where('created_at','>',Carbon::now()->startOfDay())
                ->where('created_at','<',Carbon::now()->endOfDay())
                ->get()->last();
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
        }

        $today = Carbon::now()->format('Y-m-d');

        return view('frontoffice.temperatureRegister', compact('today', 'clientThermos'));
    }

    public function getTemperatureRecordsHistory()
    {
        $user = Auth::user();
        $months = $this->months;

        $clientThermos = ClientThermo::query()->select(['id', 'type', 'imei','number'])
            ->where('user_id', $user->id)
            ->groupBy('id')
            ->get();

        $years = ThermoAverageTemperature::query()
            ->select([
                DB::raw('YEAR(created_at) as year')
            ])
            ->where('user_id', $user->id)
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
            ->where('imei', '=', $imei)
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
        $print_data = json_decode($request->get('printReport')[0]);
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
                $average->morning_temp = $inputs['valor'];
                $average->save();
            }else{
                $average = new ThermoAverageTemperature;
                $average->client_thermo = $thermo->id;
                $average->user_id = Auth::user()->client_id;
                $average->morning_temp = $inputs['valor'];
                $average->save();
            }
        }else{
            if(isset($average))
            {
                $average->afternoon_temp = $inputs['valor'];
                $average->save();
            }else{
                $average = new ThermoAverageTemperature;
                $average->client_thermo = $thermo->id;
                $average->user_id = Auth::user()->client_id;
                $average->afternoon_temp = $inputs['valor'];
                $average->save();
            }
        }
        return back();
    }
}