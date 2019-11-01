@extends('layouts.app')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/salesman/salesman.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-bar">
    <p class="container-bar_txt">{{ $salesman->name }}</p>
    <div class="container-bar_img">
        <a href="/messages/{{$user->id}}"><img style="margin-top: -3px"  src="{{ URL::to('/') }}/img/message.png"></a>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-sm-12">
                        <img class="salesman-img img-responsive" src="/img/navbar/logoindexcolor.png"/>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <b>Id:</b> {{$salesman->id}}
                        </div>
                        <div class="form-group">
                            <b>Nome:</b> {{$salesman->name}}
                        </div>
                        <div class="form-group">
                            <b>Morada:</b> {{$salesman->address}}
                        </div>
                        <div class="form-group">
                            <b>Cidade:</b> {{$salesman->city}}
                        </div>
                        <div class="form-group">
                            <b>NIF:</b> {{$salesman->nif}}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <b>Conta Corrente</b>
                        @foreach($salesPayments as $payment)
                            <div class="form-group">
                            <a href="/orders/{{$payment->order_id}}"> Venda:  {{$payment->order_id}}</a> / Fatura: {{$payment->invoice}}  / <b> Valor : {{$payment->value}}</b>
                            </div>
                        @endforeach

                        <div class="form-group">
                            <b>Total : {{$total}}</b>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        @if(Auth::user()->sales_id == null and Auth::user()->client_id == null)
                            <a class="btn btn-add" href="/salesman/deliver/{{$salesman->id}}" onclick="confirm('Tem a certeza?')">Confirmar Recebimento</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
