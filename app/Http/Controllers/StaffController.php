<?php

namespace App\Http\Controllers;



use App\DocumentSuperType;
use App\StaffPermissions;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


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

    public function addStaffPost(Request $request)
    {
        $inputs = $request->all();

        $auxClientId = Session::get('establismentID');

        $userStaff = new User();
        $userStaff->name = $inputs['ownerName'];
        $userStaff->email = $inputs['loginMail'];
        $userStaff->pin = bcrypt($inputs['pin']);
        $userStaff->password = bcrypt($inputs['password']);
        $userStaff->client_id = $auxClientId;
        $userStaff->userType = 6;
        $userStaff->save();

       $checkboxs=$inputs['type'];

       foreach ($checkboxs as $checkbox){
           $userStaffPer = new StaffPermissions();
           $userStaffPer->id_superType=$checkbox;
           $userStaffPer->client_id=$auxClientId;
           $userStaffPer->save();
       }

        return back();
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