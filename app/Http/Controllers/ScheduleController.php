<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Schedule;
use App\TechnicalHACCP;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ScheduleController extends Controller
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

    public function getSchedule(Request $request)
    {
        /*$inputs = $request->all();*/
        $months = $this->months;
        $years = Schedule::query()
            ->select([
                DB::raw('YEAR(created_at) as year')
            ])
            ->groupBy('year')
            ->get();

        $technicals = TechnicalHACCP::all();

        /*if(isset($inputs['year']) && isset($inputs['month'])){
            $scheduleCheck = Schedule::from(Schedule::alias('s'))
                ->where('s.check_s',0)
                ->leftJoin(Customer::alias('c'),'c.id','=','s.idClient')
                ->whereYear('s.date', $inputs['year'])
                ->whereMonth('s.date', $inputs['month'])
                ->select(['c.name','c.regoldiID','c.city','c.id','s.technical','s.check_s','s.id'])
                ->get();

            $scheduleUncheck = Schedule::from(Schedule::alias('s'))
                ->where('s.check_s',1)
                ->leftJoin(Customer::alias('c'),'c.id','=','s.idClient')
                ->whereYear('s.date', $inputs['year'])
                ->whereMonth('s.date', $inputs['month'])
                ->select(['c.name','c.regoldiID','c.city','c.id','s.technical','s.check_s','s.id'])
                ->get();
        }else{*/
            $scheduleCheck = Schedule::from(Schedule::alias('s'))
                ->where('s.check_s',0)
                ->leftJoin(Customer::alias('c'),'c.id','=','s.idClient')
                ->whereMonth('s.date','<=', Carbon::now()->month)
                ->select(['c.name','c.regoldiID','c.city','c.id','s.technical','s.check_s','s.id'])
                ->get();

            $scheduleUncheck = Schedule::from(Schedule::alias('s'))
                ->where('s.check_s',1)
                ->leftJoin(Customer::alias('c'),'c.id','=','s.idClient')
                ->whereMonth('s.date', Carbon::now()->month)
                ->select(['c.name','c.regoldiID','c.city','c.id','s.technical','s.check_s','s.id'])
                ->get();
        /*}*/
        $items = $scheduleCheck->merge($scheduleUncheck);

        return view('schedule.index',compact('items','technicals','months','years'));
    }

    public function editTechnical(Request $request)
    {
        $inputs = $request->all();

        $schedule = Schedule::where('id',$inputs['idSchedule'])->first();
        $schedule->technical = $inputs['idTechnical'];
        $schedule->save();

        return redirect('/schedule/haccp');
    }

    public function getScheduleByMonth(Request $request)
    {
        $date = Carbon::createFromDate($request->get('year'), $request->get('month'));
        $start_month = $date->copy()->startOfMonth();
        $end_month = $date->copy()->endOfMonth();

        $a=Schedule::from(Schedule::alias('s'))
            ->Join(Customer::alias('c'),'c.id','=','s.idClient')
            ->Join(TechnicalHACCP::alias('t'),'t.id','=','s.technical')
            ->select([
            's.idClient','s.technical','s.check_s','c.id','c.regoldiID','c.name','t.name as nameTechnical'
        ])
            ->whereBetween('s.date', [$start_month, $end_month])
            ->get();

        return $a;
    }

    public function editPossibleCustomer($id)
    {

    }

    public function editPossibleCustomerPost(Request $request,$id)
    {

    }

    public function deletePossibleCustomer($id)
    {

    }

}