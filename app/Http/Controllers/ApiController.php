<?php

namespace App\Http\Controllers;

use App\Callback;
use App\Order;
use App\Thermo;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;


class ApiController extends Controller
{

    public function confirmPayment(Request $request)
    {
        $inputs = $request->all();

        $callback = new Callback;

        $callback->request = $request;
        $callback->save();

        if ($this->http('https://services.sandbox.meowallet.pt/api/v2/callback/verify', $inputs)) {
            $callback->user_id = "entrou";
            $callback->save();
            $order = Order::where('external_id', $inputs['ext_invoiceid'])->first();
            if (isset($order)) {
                if($inputs['operation_status'] == 'COMPLETED')
                    $order->status = "paid";
                $order->save();
            } else {
                Log::debug($request);
            }
        }
        return 200;
    }

    public function receiveThermo(Request $request)
    {
        $inputs = $request->all();

        $thermo = new Thermo;

        $thermo->client_id = 0;
        $thermo->thermo_type ="Teste";
        $thermo->temperature = json_encode($inputs);
        $thermo->last_read = Carbon::now();

        $thermo->save();


        return 200;
    }

    private function http($url, $data = null, $method = null){

        $authToken    = '123a6ad89ac961d885f089ff4b82b57d19c3406e';
        $headers      = [
            'Authorization: WalletPT ' . $authToken,
            'Content-Type: application/json'
        ];
        if ($method === null) {
            $method = $data === null ? 'GET' : 'POST';
        }
        $request_data = null;
        if ($data !== null) {
            $request_data = json_encode($data);
            $headers[] = 'Content-Length: ' . strlen($request_data);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($request_data !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request_data);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        if (env('CURL_PROXY', false)) {
            curl_setopt($ch, CURLOPT_PROXY, env('CURL_PROXY'));
        }
        $response = curl_exec($ch);

        return json_decode($response);
    }
}
