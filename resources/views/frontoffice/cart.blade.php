@extends('layouts.frontoffice')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Carrinho</div>

                <div class="panel-body">

                    <table class="table table-bordered">
                        <tr>
                            <th>Img</th>
                            <th>Nome</th>
                            <th>Quantidade</th>
                            <th>Preço/Unidade</th>
                            <th>Total</th>
                            <th>Eliminar</th>

                        </tr>
                        @foreach($line_items as $item)
                            <tr>
                                <td><img style="height:25px;width:35px" src="/uploads/products/{{$item->product->file}}"></td>
                                <td>{{$item->product->name}}</td>
                                <td>{{$item->amount}}</td>
                                <td>{{$item->total/$item->amount}}€</td>
                                <td>{{number_format($item->total,2)}}€</td>
                                <td><a href="/frontoffice/cart/delete/{{$item->id}}">Eliminar</a></td>

                            </tr>

                        @endforeach

                    </table>
                    <h5>IVA(23) : {{number_format($total * 0.23,2)}}€</h5>
                    <h4>Total : {{number_format($total + 0.23*$total,2)}}€</h4>
                    <a style="float:right" href="/frontoffice/cart/process" class="btn btn-success">Finalizar Encomenda</a>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
