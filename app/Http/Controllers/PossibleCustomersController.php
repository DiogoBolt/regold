<?php

namespace App\Http\Controllers;


use App\PossibleCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class PossibleCustomersController extends Controller
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

    public function getPossibleCustomersBySales()
    {
        $user = Auth::user();

        if ($user->userType == 5) {
            $possibleCustomers = PossibleCustomer::all();
        } else {
            $possibleCustomers = PossibleCustomer::where('sales_id', $user->id)->get();
        }
        return view('possiblecustomers.index', compact('possibleCustomers'));
    }

    public function addPossibleCustomer()
    {
        return view('possiblecustomers.new');
    }

    public function addPossibleCustomerPost(Request $request)
    {
        $user = Auth::user();
        $inputs = $request->all();

        $newpossiblecustomer = new PossibleCustomer;

        $newpossiblecustomer->sales_id = $user->id;
        $newpossiblecustomer->name = $inputs['name'];
        $newpossiblecustomer->nome_cliente = $inputs['nome_cliente'];
        $newpossiblecustomer->email = $inputs['email'];
        $newpossiblecustomer->contacto = $inputs['contacto'];
        $newpossiblecustomer->address = $inputs['address'];
        $newpossiblecustomer->contract_end = $inputs['contract_end'];
        $newpossiblecustomer->current_contract = $inputs['current_contract'];

        $newpossiblecustomer->save();

        return back();
    }

    public function editPossibleCustomer($id)
    {
        $possiblecustomer = PossibleCustomer::where('id',$id)->first();

        return view('possiblecustomers.edit', compact('possiblecustomer'));
    }

    public function editPossibleCustomerPost(Request $request,$id)
    {
        $inputs = $request->all();

        $possiblecustomer = PossibleCustomer::where('id',$id)->first();

        $possiblecustomer->name = $inputs['name'];
        $possiblecustomer->nome_cliente = $inputs['nome_cliente'];
        $possiblecustomer->email = $inputs['email'];
        $possiblecustomer->contacto = $inputs['contacto'];
        $possiblecustomer->address = $inputs['address'];
        $possiblecustomer->contract_end = $inputs['contract_end'];
        $possiblecustomer->current_contract = $inputs['current_contract'];

        $possiblecustomer->save();

        return back();
    }

    public function deletePossibleCustomer($id)
    {
        $possibleCustomer = PossibleCustomer::where('id',$id)->first();

        $possibleCustomer->delete();
        return back();
    }

}