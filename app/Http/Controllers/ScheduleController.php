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

    public function getSchedule()
    {

        $months = $this->months;

        $years = Schedule::query()
            ->select([
                DB::raw('YEAR(created_at) as year')
            ])
            ->groupBy('year')
            ->get();

        $technicals = TechnicalHACCP::all();

        $schedule = Schedule::from(Schedule::alias('s'))
            ->leftJoin(Customer::alias('c'),'c.id','=','s.idClient')
            ->whereMonth('s.date', Carbon::now()->month)
            ->select(['c.name','c.regoldiID','c.city','c.id','s.technical','s.check_s'])
            ->get();

        return view('schedule.index',compact('schedule','technicals','months','years'));
    }

    public function addPossibleCustomer()
    {

    }

    public function addPossibleCustomerPost(Request $request)
    {

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