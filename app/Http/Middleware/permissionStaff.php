<?php

namespace App\Http\Middleware;

use App\StaffPermissions;
use Closure;
use Auth;
use App\Customer;
use http\Env\Request;
use Illuminate\Support\Facades\Session;

class permissionStaff
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if($user->userType==6){
            $permissionStaff=StaffPermissions::where('user_id',$user->id)->where('active',1)
                ->get();

            $permissions = [1 => 0 , 2 => 0, 3 => 0 , 4 => 0 , 5 => 0, 6 => 0];
            foreach($permissionStaff as $permission) {
                $permissions[$permission->id_superType] = 1;
            }

            if(($permissions[1] == 0) and ($request->getRequestUri()=='/frontoffice/reports' or $request->getRequestUri()=='/frontoffice/statistics' or $request->getRequestUri()=='/frontoffice/documents/HACCP')){
                return redirect('/home');
            }
            if (($permissions[2] == 0) and ($request->getRequestUri()=='/frontoffice/documents/Contabilistico')){
                return redirect('/home');
            }
            if (($permissions[3] == 0) and ($request->getRequestUri()=='/frontoffice/documents/Controlopragas' or $request->getRequestUri()=='/frontoffice/pestReports')){
                return redirect('/home');
            }
            if (($permissions[4] == 0) and ($request->getRequestUri()=='/frontoffice/records/temperatures' or $request->getRequestUri()=='/frontoffice/records/oil' or $request->getRequestUri()=='/frontoffice/records/hygiene' or $request->getRequestUri()=='/frontoffice/records/insertProduct' or $request->getRequestUri()=='/frontoffice/documents/Registos')){
                return redirect('/home');
            }
            if (($permissions[5] == 0) and ($request->getRequestUri()=='/frontoffice/categories' or $request->getRequestUri()=='/frontoffice/products/{id}' or $request->getRequestUri()=='/frontoffice/product/{id}' or $request->getRequestUri()=='/frontoffice/cart')){
                return redirect('/home');
            }
            if (($permissions[6] == 0) and ($request->getRequestUri()=='/frontoffice/orders')){
                return redirect('/home');
            }
        }
        return $next($request);
    }
}
