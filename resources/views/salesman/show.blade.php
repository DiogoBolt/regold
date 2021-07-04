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
                        <img class="salesman-img img-responsive" src="{{ URL::to('/') }}/img/logoRegolfood.png" alt="logo">
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
                      @if($user->userType==1)
                        <br/>
                            <b>Conta Corrente</b>
                            {{--@foreach($salesPayments as $payment)
                                <div class="form-group">
                                <a href="/orders/{{$payment->order_id}}"> Venda:  {{$payment->order_id}}</a> <b> Valor : {{$payment->value}}</b>
                                </div>
                            @endforeach--}}
                            <div class="form-group">
                                <b>Total : {{$total}}</b>
                            </div>
                        </div>
                    <table class="table">
                        <tr>
                            <th>Cliente</th>
                            <th>ID RegolPest</th>
                            <th>Data</th>
                            <th>Total c/iva</th>
                            <th>Detalhes</th>
                            <th>Pago</th>
                        </tr>
                        @foreach($orders as $order)
                            <tr>
                                <td><a href="/clients/{{$order->client_id}}">{{$order->name}}</a></td>
                                <td>{{$order->regoldiID}}</td>
                                <td>{{$order->created_at->format('d-m-Y')}}</td>
                                <td>{{number_format($order->total+$order->totaliva,2)}}€</td>
                                <td>@if($order->cart_id==null)(SP FREE s/ encomenda)@else<a href="/orders/{{$order->id}}">Ver encomenda</a>@endif</td>

                                {{--@if($order->status != 'paid')
                                    <td><a href="/orders/pay/{{$order->id}}" onclick="return confirm('Tem a certeza?')">Por liquidar</a></td>
                                @else
                                    <td><a href="/orders/unpay/{{$order->id}}" onclick="return confirm('Tem a certeza?')">Pago</a></td>
                                @endif--}}
                                <td class="table-checkbox">
                                    <label>
                                        <input type="checkbox" name="pay" class="pay" value="{{number_format($order->total+$order->totaliva,2)}}" data-id=" {{$order->id}} ">
                                        <span class="checkmark"></span>
                                    </label>
                                </td>

                            </tr>
                        @endforeach
                    </table>

                        {{--<div class="col-sm-12">
                            @if(Auth::user()->userType == 5)
                                <a class="btn btn-add" href="/salesman/deliver/{{$salesman->id}}" onclick="confirm('Tem a certeza?')">Confirmar Recebimento</a>
                            @endif
                        </div>--}}
                    <form action="/salesman/deliver/pay" type="POST" id="pay-form">
                        {{ csrf_field() }}
                        <a href="#" class="file-link" id="pay-link"><strong>Confirmar Pagamento (<span id="pay-numbers">0</span>€)</strong></a>
                        <input type="hidden" name="payOrders[]" value="" id="pay-items"/>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<script>

    document.addEventListener('DOMContentLoaded', function() {

        const paySpan = document.getElementById('pay-numbers');
        const payCheckboxes = document.querySelectorAll('.pay');
        const payLink = document.getElementById('pay-link');
        let payArray = [];
        let orders=0;

        payCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const orderId = this.getAttribute('data-id');
                var ordersTotal = this.getAttribute('value');

                if (this.checked) {
                    payArray.push(orderId);
                    orders = orders+parseFloat(ordersTotal);
                } else {
                    payArray = payArray.filter(id => id !== orderId);
                    orders = orders-parseFloat(ordersTotal);
                }
                paySpan.innerText = orders;
            });
        });

        payLink.addEventListener('click', function (evt) {
            evt.preventDefault();

            if (payArray.length > 0) {
                document.getElementById("pay-items").value = payArray;
                document.getElementById("pay-form").submit();
            }
        });
    });
</script>
