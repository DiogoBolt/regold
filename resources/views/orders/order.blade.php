@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Encomenda</div>

                <div class="panel-body">

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

                        </tr>
                        @foreach($line_items as $item)
                            <tr>
                                <td><img style="height:25px;width:35px" src="/uploads/products/{{$item->product->file}}"></td>
                                <td>{{$item->product->name}}</td>
                                <td>{{$item->amount}}</td>
                                <td>{{$item->total/$item->amount}}€</td>
                                <td>{{number_format($item->total,2)}}€</td>
                            </tr>

                        @endforeach

                    </table>
                    <h5>IVA(23) : {{number_format($total * 0.23,2)}}€</h5>
                    <h4>Total : {{number_format($total + 0.23*$total,2)}}€</h4>

                    <a href="/orders/process/{{$order->id}}" class="btn btn-success">Processar</a>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection
