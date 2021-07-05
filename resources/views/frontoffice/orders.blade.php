@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/orders/orders.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">encomendas</p>
        <div class="container-bar_img">
            <img src="{{ asset('img/encomendas.jpg') }}" />
        </div>
    </div>

    
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
            <li class="breadcrumb-item active" aria-current="page">Encomendas</li>
        </ol>
    </nav>

    {{-- Go Back Button --}}
    <a class="back-btn" href="/home">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Home</strong></span>
    </a>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel">
                    <div class="panel-body">

                        <table class="table table-responsive">
                            <tr>
                                <th>Data</th>
                                <th>Total c/iva</th>
                                <th>Estado</th>
                                <th>Pagamento</th>
                                <th>Detalhes</th>
                            </tr>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{date_format($order->created_at,'d-m-y')}}</td>
                                    <td>{{number_format($order->total+$order->totaliva,2)}}€</td>
                                    @if($order->shipped == 1)
                                        <td>Expedida</td>
                                        @elseif($order->processed == 1)
                                        <td>Processada</td>
                                    @else
                                        <td>Em espera</td>
                                    @endif
                                    @if($order->status=='paid')
                                        <td>Pago</td>
                                    @else
                                        <td>Não Pago</td>
                                    @endif
                                    <td><a href="/frontoffice/orders/{{$order->id}}">Ver Encomenda</a></td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
