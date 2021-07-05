@extends('layouts.app')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/orders/orders-bo.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-bar">
    <p class="container-bar_txt">encomendas</p>
    <div class="container-bar_img">
        <img src="{{ asset('img/encomendas.jpg') }}"/>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="panel">
            <div class="panel-body table-responsive">
                <table class="table">
                    <tr>
                        <th>Cliente</th>
                        <th>ID Regoldi</th>
                        <th>Data</th>
                        <th>Total c/iva</th>
                        <th>Estado</th>
                        <th>Detalhes</th>
                        <th>Pagamento</th>
                        <th>Expedição</th>
                    </tr>
                    @foreach($orders as $order)
                            <tr>
                                <td><a href="/clients/{{$order->client_id}}">{{$order->name}}</a></td>
                                <td>{{$order->regoldiID}}</td>
                                <td>{{$order->created_at->format('d-m-Y')}}</td>
                                <td>{{number_format($order->total+$order->totaliva,2)}}€</td>
                                <td>{{$order->status}}</td>
                               {{-- @if($order->invoice_id == null)
                                    <td class="form-td">
                                    <form action="/orders/attachInvoice" class="order-form" method="post" enctype="multipart/form-data">
                                        {{ csrf_field() }}

                                        <input value="{{$order->id}}" type="hidden" name="order">

                                        <label for="{{$order->id}}" class="btn"><strong>Adicionar Factura</strong></label>
                                        <input id="{{$order->id}}" class="input-order" type="file" name="receipt">
                                        
                                        <button class="btn">Associar</button>
                                    </form>
                                    </td>
                                @else
                                    <td class="form-td">
                                        <a href="{{asset('uploads/' . $order->client_id . '/' . $order->invoice)}}" class="file-link"><strong>Visualizar Factura</strong></a>
                                    </td>
                                @endif--}}

                                {{--@if($order->receipt_id == null)
                                    <td class="form-td">
                                        <form action="/orders/attachReceipt" class="order-form" method="post" enctype="multipart/form-data">
                                            {{ csrf_field() }}

                                            <input value="{{$order->id}}" type="hidden" name="order">

                                            <label for="{{$order->id}}" class="btn"><strong>Adicionar Recibo</strong></label>
                                            <input id="{{$order->id}}" class="input-order" type="file" name="receipt">

                                            <button class="btn">Associar</button>
                                        </form>
                                    </td>
                                @else
                                    <td class="form-td">
                                        <a href="{{asset('uploads/' . $order->client_id . '/' . $order->receipt)}}" class="file-link"><strong>Visualizar Recibo</strong></a>
                                    </td>
                                @endif--}}
                                <td><a href="/orders/{{$order->id}}">Detalhes</a></td>
                                {{--@if($user->userType==1)--}}
                                <@if($order->status_salesman == 0)
                                    <td><a href="/salesman/orderPay/{{$order->id}}" onclick="return confirm('Tem a certeza?')">Liquidar</a></td>
                                @else
                                    <td><a href="/salesman/orderUnpay/{{$order->id}}" onclick="return confirm('Tem a certeza?')">Pago</a></td>
                                @endif
                                {{--@else
                                    @if($user->status=='paid')
                                        <td>Pago</td>
                                    @else
                                        <td>Não Pago</td>
                                    @endif
                                @endif--}}
                                @if($user->shipped==0)
                                    <td>Por expedir</td>
                                @else
                                    <td>Expedida</td>
                                @endif
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