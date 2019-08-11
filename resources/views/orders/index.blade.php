@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Encomendas</div>

                <div class="panel-body">
                    <h5 style="color:darkorange">Em Espera</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>ID Cliente</th>
                            <th>Total</th>
                            <th>Total + Iva</th>
                            <th>Estado</th>
                            <th>Fatura</th>
                            <th>Detalhes</th>


                        </tr>
                        @foreach($orders as $order)
                            @if($order->processed == 0)
                            <tr>
                                <td><a href="/clients/{{$order->client_id}}">{{$order->client_id}}</a></td>
                                <td>{{number_format($order->total,2)}}€</td>
                                <td>{{number_format($order->totaliva,2)}}€</td>
                                <td>Em Espera</td>
                                @if($order->receipt_id == null)
                                    <td>
                                    <form action="/orders/attachReceipt"  method="post" enctype="multipart/form-data">
                                        {{ csrf_field() }}

                                        <input class="form-control" type="file" name="receipt">
                                        <input value="{{$order->id}}" type="hidden" name="order">
                                        <button class="btn btn-success">Adicionar Fatura</button>
                                    </form>
                                    </td>
                                @else
                                    <td>FALTA</td>
                                @endif
                                <td><a href="/orders/{{$order->id}}">Detalhes</a></td>
                                </tr>

                        @endif
                        @endforeach

                    </table>


                    <h5 style="color:green">Processadas</h5>

                    <table class="table table-bordered">
                        <tr>
                            <th>ID Cliente</th>
                            <th>Total</th>
                            <th>Total + Iva</th>
                            <th>Estado</th>
                            <th>Detalhes</th>

                        </tr>
                        @foreach($orders as $order)
                            @if($order->processed == 1)
                                <tr>
                                    <td><a href="/clients/{{$order->client_id}}">{{$order->client_id}}</a></td>
                                    <td>{{number_format($order->total,2)}}€</td>
                                    <td>{{number_format($order->totaliva,2)}}€</td>
                                    <td>Processado</td>

                                    <td><a href="/orders/{{$order->id}}">Detalhes</a></td>
                                </tr>
                            @endif
                        @endforeach

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
