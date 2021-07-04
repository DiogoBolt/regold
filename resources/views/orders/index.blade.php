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

                <a class="file-link"  id="filter-link" data-toggle="collapse" href="#collapseFilter" role="button" aria-expanded="false" aria-controls="collapseFilter">
                   <strong>Filtrar Encomendas</strong>
                </a>

                <div class="collapse" id="collapseFilter">
                    <form action="/orders/filter/q" method="GET" id="filter-form">
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
                        <th></th>
                        <th>Cliente</th>
                        <th>ID RegolPest</th>
                        <th>Data</th>
                        <th>Total s/iva</th>
                        <th>Detalhes</th>
                        <th>Lançada</th>
                    </tr>
                    @foreach($orders as $order)
                            <tr>
                                <td>
                                    <i class="fa fa-trash fa-lg" data-toggle="modal" data-target="#deleteModal"
                                            data-item="{{ $order }}">
                                    </i>
                                </td>
                                <td><a href="/clients/{{$order->client_id}}">{{$order->name}}</a></td>
                                <td>{{$order->regoldiID}}</td>
                                <td>{{$order->created_at->format('d-m-Y')}}</td>
                                <td>{{number_format($order->total,2)}}€</td>
                                {{--@if($order->invoice_id == null)
                                    <td class="form-td">
                                    <form action="/orders/attachInvoice" class="order-form" method="post" enctype="multipart/form-data">
                                        {{ csrf_field() }}

                                        <input value="{{$order->id}}" type="hidden" name="order">

                                        <label for="{{$order->id}}" class="btn"><strong>Adicionar Factura</strong></label>
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
                                        <a href="{{asset('uploads/' . $order->client_id . '/' . $order->invoice)}}" class="file-link"><strong>Visualizar Factura</strong></a>
                                    </td>
                                @endif--}}

                                <td>@if($order->cart_id==null)(SP FREE s/ encomenda)@else<a href="/orders/{{$order->id}}">Ver Encomenda</a>@endif</td>


                                <td><a href="/orders/process/{{$order->id}}" class="btn btn-process">
                                    <strong>Lançar</strong>
                                </a></td>
                                {{--<td class="table-checkbox">
                                    <label> 
                                        <input type="checkbox" name="print" class="print" data-id="{{ $order->id }}">
                                        <span class="checkmark"></span>
                                    </label>
                                </td>--}}
                            </tr>
                    @endforeach
                </table>
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">x</button>
                <h4 class="modal-title">Apagar Encomenda</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn modal-del" id="delete-order">
                    <strong>Apagar</strong>
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <strong>Cancelar</strong>
                </button>
            </div>
        </div>
    </div>
</div>

<form action="/order/delete" method="post" id="delete-form">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="delete"/>
    <input type="hidden" id="order-id" value="" name="id">
</form>

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

document.addEventListener('DOMContentLoaded', function () {

    $('#deleteModal').on('show.bs.modal', function (event) {
        let item = $(event.relatedTarget);
        let data = item.data('item');

        $(this).find('.modal-body').text(`Tem a certeza que pretende apagar esta encomenda? `);

        $('#delete-order').on('click', function () {
            $('#order-id').val(data.id);
            $('#delete-form').submit();
        });

    });

    $("#deleteModal").on("hidden.bs.modal", function () {
        $('#delete-order').unbind('click');
    });

}, false);


</script>