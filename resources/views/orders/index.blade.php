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
    @if(isset($error))
        <div align="center" style="color:red">{{$error}}</div>
        @endif
    <div class="row">
        <div class="panel">
            <div class="panel-body table-responsive">
                <table class="table">
                    <tr>
                        <th>Cliente</th>
                        <th>ID Regoldi</th>
                        <th>Total</th>
                        <th>Fatura</th>
                        <th>Detalhes</th>
                        <th>Pago</th>
                        <th>Processar</th>
                    </tr>
                    @foreach($orders as $order)
                        @if($order->processed == 0)
                            <tr>
                                <td><a href="/clients/{{$order->client_id}}">{{$order->name}}</a></td>
                                <td>{{$order->regoldiID}}</td>
                                <td>{{number_format($order->total,2)}}€</td>
                                @if($order->invoice_id == null)
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
                                @endif
                                <td><a href="/orders/{{$order->id}}">Detalhes</a></td>
                                @if($order->status != 'paid')
                                    <td><a href="/orders/pay/{{$order->id}}">Pagar</a></td>
                                @else
                                    <td>Pago</td>
                                @endif
                                <td><a href="/orders/process/{{$order->id}}" class="btn btn-process">
                                    <strong>Processar</strong>
                                </a></td>
                                </tr>

                        @endif
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

$('#submit').click(function () {
    if (this.id == 'submit1') {
        alert('Submit 1 clicked');
    }
    else if (this.id == 'submit2') {
        alert('Submit 2 clicked');
    }
});

</script>