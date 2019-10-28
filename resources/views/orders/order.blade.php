@extends('layouts.app')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/orders/order.css') }}" rel="stylesheet">
    <link href="{{ asset('css/orders/orders-bo.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-bar">
    <p class="container-bar_txt">encomenda</p>
    <div class="container-bar_img">
        <img src="{{ asset('img/encomendas.jpg') }}" />
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-body table-responsive" >

                    @if($order->processed == 1)
                        <h5 style="color:green">Processado</h5>
                    @else
                        <h5 style="color:darkorange">Em Espera</h5>
                    @endif
                    <table class="table table-bordered">
                        <tr>
                            <th>Img</th>
                            <th>Nome</th>
                            <th>Quantidade</th>
                            <th>Preço/Unidade</th>
                            <th>Total</th>
                            <th>Fatura</th>
                            <th>Recibo</th>

                        </tr>
                        @foreach($line_items as $item)
                            <tr>
                                <td><img style="height:25px;width:35px" src="/uploads/products/{{$item->product->file}}"></td>
                                <td>{{$item->product->name}}</td>
                                <td>{{$item->amount}}</td>
                                <td>{{$item->total/$item->amount}}€</td>
                                <td>{{number_format($item->total,2)}}€</td>
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

                                @if($order->receipt_id == null)
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
                                @endif
                            </tr>

                        @endforeach

                    </table>

                    <div class="order-info">
                        <h4>Total : {{number_format($total + 0.23*$total,2)}}€</h4>
                        <h5>IVA(23) : {{number_format($total * 0.23,2)}}€</h5>
                    </div>

                    <a href="/orders/process/{{$order->id}}" class="btn btn-process">
                        <strong>Processar</strong>
                    </a>

                    <a href="/order/print/{{$order->id}}" target="_blank" class="btn btn-process">
                        <strong>Imprimir</strong>
                    </a>
                    <br>
                        @if(isset($salesman))
                       <h5>Vendedor: {{$salesman->name}}</h5>
                            @endif



                </div>
            </div>
        </div>
    </div>
</div>

@endsection