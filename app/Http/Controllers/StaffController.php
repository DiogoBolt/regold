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
        $auxClientId = Session::get('establismentID');

        $userStaff=User::where('client_id',$auxClientId)
            ->where('userType',6)
            ->get();

        return view('frontoffice.indexStaff',compact('userStaff'));
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
           $userStaffPer->user_id=$userStaff->id;
           $userStaffPer->save();
       }
        return back();
    }

    public function editStaff($id)
    {
        $userStaff = User::where('id',$id)->first();

        $staffPermissions=StaffPermissions::where('user_id',$id)->get();

            $permissions = [1 => 0 , 2 => 0, 3 => 0 , 4 => 0 , 5 => 0, 6 => 0];
                foreach($staffPermissions as $permission) {
                    $permissions[$permission->id_superType] = 1;
                }

        return view('frontoffice.editStaff',compact('userStaff','types','staffPermission','permissions'));
    }

    public function editStaffPost(Request $request,$id)
    {
        $inputs=$request->all();

        $userStaff=User::where('id',$id)->first();

        $userStaff->name=$inputs['name'];
        $userStaff->email=$inputs['email'];

     /*   $checkboxs=$inputs['type'];

        foreach ($checkboxs as $checkbox){
            $userStaffPer = new StaffPermissions();
            $userStaffPer->id_superType=$checkbox;
            $userStaffPer->user_id=$userStaff->id;
            $userStaffPer->save();
        }*/

        $options = [
            'cost' => 10
        ];
        if($inputs['password']!=""){
            $userStaff->password = password_hash($inputs['password'], PASSWORD_BCRYPT, $options);
            $userStaff->save();
        }
        if($inputs['pin']!=""){
            $userStaff->pin=password_hash($inputs['pin'], PASSWORD_BCRYPT, $options);
            $userStaff->save();
        }
        $userStaff->save();
        return back();
    }

    public function deleteStaff($id)
    {
        $userStaff=User::where('id',$id)->first();
        $userStaff->delete();

        return back();
    }

}