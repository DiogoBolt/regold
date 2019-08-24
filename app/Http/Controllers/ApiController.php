<?php

namespace App\Http\Controllers;

use App\Callback;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ApiController extends Controller
{
    /**
     * Create a new controller instance.
     *

     * */
    public function confirmPayment(Request $request)
    {
        $inputs = $request->all();

        $callback = new Callback;

        $callback->request = $request;
        $callback->save();

        if ($this->http('https://services.sandbox.meowallet.pt/api/v2/callback/verify', $request)) {
            $order = Order::where('external_id', $inputs['ext_invoiceid'])->first();
            if (isset($order)) {
                if($inputs['operation_status'] == 'COMPLETED')
                    $order->status = "payed";
                $order->save();
            } else {
                Log::debug($request);
            }
        }
        return 200;
    }
}
