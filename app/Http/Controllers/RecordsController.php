<?php
namespace App\Http\Controllers;

use App\ClientThermo;
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
        }

        $today = Carbon::now()->format('Y-m-d');

        return view('frontoffice.temperatureRegister', compact('today', 'clientThermos'));
    }

    public function getTemperatureRecordsHistory()
    {
        $user = Auth::user();
        $months = $this->months;

        $clientThermos = ClientThermo::query()->select(['id', 'type', 'imei'])
            ->where('user_id', $user->id)
            ->groupBy('id')
            ->get();

        return view('frontoffice.temperatureRegisterHistory', compact(['clientThermos', 'months']));
    }

    public function getHistoryByMonth(Request $request)
    {
        $month = Carbon::create()->month($request->get('month'));
        $start_month = $month->copy()->startOfMonth();
        $end_month = $month->copy()->endOfMonth();
        $imei = $request->get('imei');

        return ThermoAverageTemperature::query()->select([
            'morning_temp', 'afternoon_temp', DB::raw('DAY(updated_at) as day'),
        ])
            //->where('imei', '=', $imei)
            ->whereBetween('updated_at', [$start_month, $end_month])
            ->get();
    }
}