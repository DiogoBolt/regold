<?php
namespace App\Http\Controllers;

use App\AreaSectionClient;
use App\CleaningFrequency;
use App\ClientSection;
use App\ClientThermo;
use App\EquipmentSectionClient;
use App\FridgeType;
use App\OilRecord;
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

    public function insertConformities()
    {


        return view('frontoffice.insertProductConformities',compact('oil_records'));
    }

    public function insertOilRecords()
    {
        /*$UserTypes = UserType::all();*/


        return view('frontoffice.oilRecords'/*,compact('UserTypes')*/);

    }
    public function saveOilRecords(Request $request)
    {
        dd("dsf");
        $user = Auth::user();

        $auxClientId = Session::get('establismentID');

        $inputs = $request->all();

        $oil_records= new OilRecord();
        $oil_records->report_date= $inputs['report_date'];
        $oil_records->oil_aspect=$inputs['oil_aspect'];

        $oil_records->client_id = $auxClientId;

        $oil_records->save();

        return redirect('/frontoffice/documents/registos',compact('oil_records'));
    }

    public function getTemperatureRecords()
    {
        $user = Auth::user();

        $clientThermos = ClientThermo::query()->where('user_id', $user->id)->get();

        foreach ($clientThermos as $clientthermo) {
            $clientthermo->thermo = Thermo::query()->where('imei', $clientthermo->imei)->get()->last();
            $clientthermo->fridgeType = FridgeType::query()->where('id', $clientthermo->type)->first();
            $clientthermo->average = ThermoAverageTemperature::query()
                ->where('imei', $clientthermo->imei)
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

    public function getHygieneRecords()
    {
        $user = Auth::user();

        $sections = ClientSection::where('id_client',$user->id)->get();

        foreach($sections as $section)
        {
            $section->equipments = EquipmentSectionClient::where('idSection',$section->id)->get();
            $section->areas = AreaSectionClient::where('idSection',$section->id)->get();
        }
        
        $today = Carbon::now()->format('Y-m-d');

        return view('frontoffice.hygieneRegister', compact('today'));
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
}