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

                <form action="/order/printOrders" type="POST" id="print-form">
                    {{ csrf_field() }}
                    <a href="#" class="file-link" id="print-link"><strong>Imprimir Documentos (<span id="print-numbers">0</span>)</strong></a>
                    <input type="hidden" name="printOrders[]" value="" id="print-items"/>
                </form>
                <table class="table">
                    <tr>
                        <th>Cliente</th>
                        <th>ID Regoldi</th>
                        <th>Total</th>
                        <th>Fatura</th>
                        <th>Detalhes</th>
                        <th>Pago</th>
                        <th>Processar</th>
                        <th>Imprimir</th>
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
                                <td class="table-checkbox">
                                    <label> 
                                        <input type="checkbox" name="print" class="print" data-id="{{ $order->id }}">
                                        <span class="checkmark"></span>
                                    </label>
                                </td>
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

    const printButton = document.getElementById('print-link');
    const printSpan = document.getElementById('print-numbers');
    const printCheckboxes = document.querySelectorAll('.print');
    const printLink = document.getElementById('print-link');
    let printArray = []; 

    $('.input-order').change( function() {

        let file = $(this)[0].files[0];

        if(file) {
            $(this).prev('label').text(file.name);
        } else {
            $(this).prev('label').text('Adicionar Factura');
        }
        
    });

    printCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const orderId = this.getAttribute('data-id');

            if(this.checked) {
                printArray.push(orderId);
            } else {
                printArray = printArray.filter(id => id !== orderId);
            }

            printSpan.innerText = printArray.length;
        });
    });
    
    printLink.addEventListener('click', function(evt){
        evt.preventDefault();

        if(printArray.length > 0) {
            document.getElementById("print-items").value = printArray; 
            document.getElementById("print-form").submit();
        }
    });


});

</script>