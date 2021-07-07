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
                    <table id="dataTable" class="table table-bordered">

                        <tr>
                            <th>Img</th>
                            <th hidden id="csv">NºCliente</th>
                            <th id="csv">Nome</th>
                            <th id="csv">Ref</th>
                            <th id="csv">Quantidade</th>
                            <th id="csv">Preço/Unidade</th>
                            <th id="csv">Total</th>
                            <th>Fatura</th>
                            <th>Recibo</th>
                            <th hidden><h5 id="csv">Serviço HACCP : {{number_format($serHaccp,2)}}€</h5></th>
                        </tr>
                        @foreach($line_items as $item)
                            <tr>
                                <td><img style="height:25px;width:35px" src="/uploads/products/{{$item->product->file}}"></td>
                                <td hidden id="csv">{{$client->regoldiID}}</td>
                                <td id="csv">{{$item->product->name}}</td>
                                <td id="csv">{{$item->ref}}</td>
                                <td id="csv">{{$item->amount}}</td>
                                <td id="csv">{{$item->total/$item->amount}}€</td>
                                <td id="csv">{{number_format($item->total,2)}}€</td>
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
                        <div class="form-group">
                            <b style="color:red">Nota de encomenda: </b> <b>{{$order->note}}</b>
                        </div>
                        <div class="form-group">
                            <b style="color:red">Nota de transporte: </b> <b>{{$order->transport_note}}</b>
                        </div>
                    <div class="order-info">
                        <h4>Total : {{number_format($order->total,2)}}€</h4>
                        @if($serHaccp!=0)
                        <h5 id="csv">Serviço HACCP : {{number_format($serHaccp,2)}}€</h5>
                        @endif
                        <h5>IVA(23) : {{number_format($order->total * 0.23,2)}}€</h5>
                        <h5>Total + IVA(23) : {{number_format($order->total * 1.23,2)}}€</h5>
                    </div>
                        @if($order->processed == 1)
                        @else
                            <a href="/orders/process/{{$order->id}}" class="btn btn-process">
                                <strong>Lançar</strong>
                            </a>
                        @endif

                    <a href="/order/print/{{$order->id}}" target="_blank" class="btn btn-process">
                        <strong>Imprimir</strong>
                    </a>

                    <button class="btn btn-process" onclick="exportCSV()">Exportar Excel</button>

                    <br>
                       @if(isset($salesman))
                       <h5>Vendedor: {{$salesman->name}}</h5>
                       @endif
                    </br>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<script>
    function exportCSV() {
        let data = "";
        const tableData = [];
        const rows = document.querySelectorAll("table tr");
        for (const row of rows) {
            const rowData = [];
            for (const [index, column] of row.querySelectorAll("th[id='csv'],td[id='csv'],h5[id='csv']").entries()) {
                if ((index + 1) % 3 === 0) {
                    rowData.push('"' + column.innerText + '"');
                } else {
                    rowData.push(column.innerText);
                }
            }
            tableData.push(rowData.join(";"));
        }

        data += tableData.join("\n");
        const a = document.createElement("a");
        a.href = URL.createObjectURL(new Blob(["\uFEFF"+data], { type: 'text/csv;charset=utf-18;' }));
        a.setAttribute("download", "encomenda.csv");
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }
</script>