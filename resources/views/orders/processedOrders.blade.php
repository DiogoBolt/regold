@extends('layouts.app')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/orders/orders-bo.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-bar">
    <p class="container-bar_txt">encomendas</p>
    <div class="container-bar_img">
        <img src="{{ asset('img/encomendas.jpg') }}" />
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="panel">
            <div class="panel-body table-responsive">

                <a class="file-link"  id="filter-link" data-toggle="collapse" href="#collapseFilter" role="button" aria-expanded="false" aria-controls="collapseFilter">
                    <strong>Filtrar Encomendas</strong>
                </a>
        
                <div class="collapse" id="collapseFilter">
                    <form action="/processedOrders/filter" method="GET" id="filter-form">
                        <div class="card card-body">
                            <label for="client-filter">Cliente</label>
                            <input type="text" id="client-filter" class="form-control" name="client">

                            <label for="payment-filter">Método de Pagamento</label>
                            <select class="form-control" id="payment-filter" name="payment_method">
                                <option value="" selected disabled>Seleccione método</option>
                                <option value="Debito Direto">Débito Direto</option>
                                <option value="Contra Entrega">Contra Entrega</option>
                                <option value="Fatura Contra Fatura">Fatura Contra Fatura</option>
                                <option value="30 dias">30 dias</option>
                            </select>

                            <label for="status-filter">Estado</label>
                            <select class="form-control" id="status-filter" name="status">
                                    <option value="" selected disabled>Seleccione estado</option>
                                    <option value="paid">Pago</option>
                                    <option value="waiting_payment">Aguardando pagamento</option>
                            </select>

                            <label for="process-filter">Data de Processamento</label>
                            <input type="date" id="process-filter" class="form-control" name="start_date">
                            - entre - 
                            <input type="date" class="form-control" name="end_date">

                            <button class="btn" type="submit" form="filter-form">Filtrar</button>
                        </div>
                    </form>
                </div>

                <table class="table">
                    <tr>
                        <th>Cliente</th>
                        <th>ID Regoldi</th>
                        <th>Total</th>
                        <th>Abater</th>
                        <th>Estado</th>
                        <th>Recibo</th>
                        <th>Pago</th>
                        <th>Detalhes</th>
                    </tr>
                    @foreach($orders as $order)
                            <tr>
                                <td><a href="/clients/{{$order->client_id}}">{{$order->comercial_name}}</a></td>
                                <td>{{$order->regoldiID}}</td>
                                <td>{{number_format($order->total,2)}}€</td>
                                @if($order->status != 'paid')
                                <td><form  method="post" action="/orders/semipay">
                                        {{ csrf_field() }}
                                        <input name="amount" style="width:40%;display:inline" class="form-control">
                                        <input name="id" style="display:none" value="{{$order->id}}">
                                        <button style="display:inline" class="btn btn-success">Abater</button></form></td>
                                @else
                                    <td></td>
                                @endif
                                <td>{{$order->status}}</td>
                                @if($order->receipt_id == null)
                                    <td class="form-td">
                                        <form action="/orders/attachReceipt" class="order-form" method="post" enctype="multipart/form-data">
                                            {{ csrf_field() }}

                                            <input value="{{$order->id}}" type="hidden" name="order">

                                            <label for="{{$order->id}}" class="btn"><strong>Adicionar Recibo</strong></label>
                                            <input id="{{$order->id}}" class="input-order" type="file" name="receipt">

                                            <button class="btn">Associar</button>
                                        </form>
                                        @if ($errors->has('receipt'))
                                            <div class="alert-danger">
                                                {{  $errors->first('receipt') }}
                                            </div>
                                        @endif
                                    </td>
                                @else
                                    <td class="form-td">
                                        <a href="{{asset('uploads/' . $order->client_id . '/' . $order->receipt)}}" class="file-link"><strong>Visualizar Recibo</strong></a>
                                    </td>
                                @endif

                                @if($order->status != 'paid')
                                    <td><a href="/orders/pay/{{$order->id}}" onclick="return confirm('Tem a certeza?')">Pagar</a></td>
                                @else
                                    <td><a href="/orders/unpay/{{$order->id}}" onclick="return confirm('Tem a certeza?')">Pago</a></td>
                                @endif
                                <td><a href="/orders/{{$order->id}}">Detalhes</a></td>
                                </tr>
                    @endforeach

                </table>
            </div>
        </div>
    </div>
</div>

@endsection

<script>

document.addEventListener('DOMContentLoaded', function() { 

    $('.input-order').change( function() {

        let file = $(this)[0].files[0];

        if(file) {
            $(this).prev('label').text(file.name);
        } else {
            $(this).prev('label').text('Adicionar Factura');
        }
        
    });

});

</script>