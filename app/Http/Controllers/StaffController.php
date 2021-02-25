<?php

namespace App\Http\Controllers;



use App\Customer;
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

        $client=Customer::where('id',$auxClientId)->first();

        return view('frontoffice.indexStaff',compact('userStaff','client'));
    }

    public function addStaff()
    {
        $auxClientId = Session::get('establismentID');

        $client=Customer::where('id',$auxClientId)->first();

        $types=DocumentSuperType::all();

        return view('frontoffice.newStaff',compact('types','client'));
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
           $userStaffPer->active=1;
           $userStaffPer->user_id=$userStaff->id;
           $userStaffPer->save();
       }
        return redirect('/frontoffice/staff');
    }

    public function editStaff($id)
    {
        $auxClientId = Session::get('establismentID');
        $userStaff = User::where('id',$id)->first();

        $client=Customer::where('id',$auxClientId)->first();

        $staffPermissions=StaffPermissions::where('user_id',$id)->where('active',1)->get();

            $permissions = [1 => 0 , 2 => 0, 3 => 0 , 4 => 0 , 5 => 0, 6 => 0];
                foreach($staffPermissions as $permission) {
                    $permissions[$permission->id_superType] = 1;
                }

        return view('frontoffice.editStaff',compact('userStaff','types','staffPermission','permissions','client'));
    }

    public function editStaffPost(Request $request,$id)
    {
        $inputs=$request->all();

        $userStaff=User::where('id',$id)->first();

        $userStaff->name=$inputs['name'];
        $userStaff->email=$inputs['email'];

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

        if(isset($inputs['type'])){
            $checkboxs=$inputs['type'];
            $permissions = [1 => 0 , 2 => 0, 3 => 0 , 4 => 0 , 5 => 0, 6 => 0];
            foreach($checkboxs as $checkbox) {
                $permissions[$checkbox] = 1;
            }

            $i=0;
            foreach ($permissions as $permission){
                $i++;
                if ($permission==1) {
                    $checked = StaffPermissions::where('user_id', $id)->where('id_superType', $i)->first();
                    if (!$checked) {
                        $userStaffPer = new StaffPermissions();
                        $userStaffPer->id_superType =$i;
                        $userStaffPer->active=1;
                        $userStaffPer->user_id = $id;
                        $userStaffPer->save();
                    } else {
                        $checked->active=1;
                        $checked->save();
                    }
                } else{
                    $checked = StaffPermissions::where('user_id', $id)->where('id_superType', $i)->first();
                    if($checked){
                        $checked->active=0;
                        $checked->save();
                    }
                }
            }
        }else{
            $checkeds = StaffPermissions::where('user_id', $id)->get();
            foreach ($checkeds as $checked){
                $checked->active=0;
                $checked->save();
            }
        }


        return back();
    }

    public function deleteStaff($id)
    {
        $userStaff=User::where('id',$id)->first();
        $userStaff->delete();

        return back();
    }

}