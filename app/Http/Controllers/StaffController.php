<?php

namespace App\Http\Controllers;



use App\DocumentSuperType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class StaffController extends Controller
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

    public function getStaff()
    {

        return view('frontoffice.indexStaff');
    }

    public function addStaff()
    {
        $types=DocumentSuperType::all();

        return view('frontoffice.newStaff',compact('types'));
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