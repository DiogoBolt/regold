@extends('layouts.frontoffice')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Encomendas</div>

                <div class="panel-body">

                    <table class="table table-bordered">
                        <tr>
                            <th>Data</th>
                            <th>Total</th>
                            <th>Total + Iva</th>
                            <th>Estado</th>

                        </tr>
                        @foreach($orders as $order)
                            <tr>
                                <td><a href="/frontoffice/orders/{{$order->id}}">{{date_format($order->created_at,'d-m-y')}}</a></td>
                                <td>{{number_format($order->total,2)}}€</td>
                                <td>{{number_format($order->totaliva,2)}}€</td>
                                @if($order->processed == 1)
                                    <td>Processado</td>
                                    @else
                                    <td>Em Espera</td>
                                @endif
                            </tr>

                        @endforeach

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
