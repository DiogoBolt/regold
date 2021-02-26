<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Customer;
use http\Env\Request;
use Illuminate\Support\Facades\Session;

class permissionClient
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
        $auxClientId = Session::has('clientImpersonatedId') ? Session::get('clientImpersonatedId') : Session::get('establismentID');

        $clientPermission=Customer::where('id',$auxClientId)
        ->first();

        if (($clientPermission->permission == 1) and ($request->getRequestUri()=='/frontoffice/documents/Controlopragas' or $request->getRequestUri()=='/frontoffice/documents/HACCP' or $request->getRequestUri()=='/frontoffice/records/oil' or $request->getRequestUri()=='/frontoffice/records/hygiene' or $request->getRequestUri()=='/frontoffice/records/insertProduct')) {
            return redirect('/home');
        }
        if(($clientPermission->permission==3) and ($request->getRequestUri()=='/frontoffice/documents/Controlopragas'))
        {
            return redirect('/home');
        }
        if(($clientPermission->permission==2) and ($request->getRequestUri()=='/frontoffice/documents/HACCP'))
        {
            return redirect('/home');
        }

        return $next($request);
    }
}
