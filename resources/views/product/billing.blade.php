@extends('layouts.app')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{asset('css/orders/orders-bo.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">faturação</p>
        <div class="container-bar_img">
            <img src="{{ asset('img/encomendas.jpg') }}" />
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="panel">
                <div class="panel-body table-responsive">

                    <table class="table">
                        <tr>
                            <th>Total Faturado</th>
                            <th>Total Liquidado</th>
                            <th>Total por liquidar</th>
                        </tr>
                        <tr>
                            <td>{{number_format($totalBilled,2)}}€</td>
                            <td>{{number_format($totalPaid,2)}}€</td>
                            <td>{{number_format($totalUnpaid,2)}}€</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="panel">
                <div class="panel-body table-responsive">

                    <table class="table">

                        @foreach($clients as $client)
                            @if($client->totalUnpaidAmount!=0)

                            <tr>
                                <th>Cliente</th>
                                <th>ID Regoldi</th>
                                <th>Atividade</th>
                                <th>Total não pago</th>
                            </tr>
                            <tr>
                                <td><a style="color:red" href="/clients/{{$client->client_id}}">{{$client->name}}</a></td>
                                <td>{{$client->regoldiID}}</td>
                                <td>{{$client->activity}}</td>
                                <td>{{number_format($client->totalUnpaidAmount,2)}}€</td>
                            </tr>
                            <tr>
                                <th style="background: #bde797">Total</th>
                                <th style="background: #bde797">Estado</th>
                                <th style="background: #bde797">Data</th>
                                <th style="background: #bde797">Detalhes</th>
                            </tr>

                            @foreach($client->orders as $order)

                            <tr>
                                <td>{{number_format($order->total,2)}}€</td>
                                <td>{{$order->status}}</td>
                                <td>{{$order->created_at}}</td>
                                <td><a href="/orders/{{$order->id}}">Detalhes</a></td>
                            <tr>

                            @endforeach
                            @endif
                        @endforeach

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
<script language="javascript">
    setTimeout(function(){
        window.location.reload(1);
    }, 20000);
</script>