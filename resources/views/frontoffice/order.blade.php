@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/orders/orders.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">encomenda</p>
        <div class="container-bar_img">
            <img src="{{ asset('img/encomendas.jpg') }}" />
        </div>
    </div>


    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
            <li class="breadcrumb-item " aria-current="page">Encomendas</li>
            <li class="breadcrumb-item active" aria-current="page">Encomenda</li>
        </ol>
    </nav>

    {{-- Go Back Button --}}
    <a class="back-btn" href="/frontoffice/orders">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Encomendas</strong></span>
    </a>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body table-responsive">
                        @if($order->processed == 1)
                            <h5 style="color:green">Processado</h5>
                        @else
                            <h5 style="color:darkorange">Em Espera</h5>
                        @endif
                        <table class="table">
                            <tr>
                                <th>Img</th>
                                <th>Nome</th>
                                <th>Quantidade</th>
                                <th>Preço/Unidade</th>
                                <th>Total</th>
                            </tr>
                            @foreach($line_items as $item)
                                <tr>
                                    <td><img src="/uploads/products/{{$item->product->file}}"></td>
                                    <td>{{$item->product->name}}</td>
                                    <td>{{$item->amount}}</td>
                                    <td>{{$item->total/$item->amount}}€</td>
                                    <td>{{number_format($item->total,2)}}€</td>
                                </tr>
                            @endforeach
                        </table>
                            <div class="order-info">
                                <h4>Total : {{number_format($order->total,2)}}€</h4>
                                @if($extra>0 && $extra!=5)
                                <h5>Serviço HACCP : {{number_format($extra,2)}}€</h5>
                                @elseif($extra==5)
                                <h5>Portes : {{number_format($extra,2)}}€</h5>
                                @endif
                                <h5>IVA(23) : {{number_format($order->total * 0.23,2)}}€</h5>
                                <h5>Total + IVA(23) : {{number_format($order->total * 1.23,2)}}€</h5>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
