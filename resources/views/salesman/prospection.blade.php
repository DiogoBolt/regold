@extends('layouts.app')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/salesman/prospection.css') }}" rel="stylesheet">


@endsection

@section('content')
<div class="container-bar">
    <p class="container-bar_txt">Prospeção</p>
    <div class="container-bar_img">
        <img src="{{ asset('img/encomendas.jpg') }}" />
    </div>
</div>

<div class="container">
    <div class="prospection_container">

        <div>
            <a href="/possiblecustomers/new" style="margin-top: 20px; float: left;" class="btn btn-add">Novo Potencial Cliente</a>

            <table class="table">
                <tr>
                    <th colspan="2">POTENCIAIS CLIENTES</th>
                </tr>

                <tr>
                    <td>CLIENTES SP</td>
                    <td><a {{--href="/clientsOrder/sp"--}} style="color: red"></a> / <a {{--href="/clientsPack/sp"--}}></a></td>
                </tr>
                <tr>
                    <td>CLIENTES SP Free</td>
                    <td><a {{--href="/clientsOrder/sp free"--}} style="color: red"></a> / <a {{--href="/clientsPack/sp free"--}}></a></td>
                </tr>
                <tr>
                    <td>CLIENTES S</td>
                    <td><a {{--href="/clientsOrder/s"--}} style="color: red"></a> / <a {{--href="/clientsPack/s"--}}></a></td>
                </tr>
                <tr>
                    <td>CLIENTES ST</td>
                    <td><a {{--href="/clientsOrder/st"--}} style="color: red"></a> / <a {{--href="/clientsPack/st"--}}></a></td>
                </tr>
                <tr>
                    <td>CLIENTES T</td>
                    <td><a {{--href="/clientsOrder/t"--}} style="color: red"></a> / <a {{--href="/clientsPack/t"--}}></a></td>
                </tr>
                <tr>
                    <td>TOTAL</td>
                    <td><a style="color: red" {{--href="/clientsOrder/all"--}}></a> / <a {{--href="/clients"--}}></a></td>
                </tr>
            </table>
        </div>

        <div style="overflow-x:auto;">
            <table class="table">
                <tr>
                    <th></th>
                    <th>Nome</th>
                    <th>Pessoa Contacto</th>
                    <th>Contacto</th>
                    <th>Localidade</th>
                    <th>Final contrato</th>
                    <th>Data Visita</th>
                </tr>
                @foreach($possibleCustomers as $possible_customer)
                <tr>
                    <td><a href="/possiblecustomers/deletecustomer/{{$possible_customer->id}}">X</a></td>
                    <td>{{$possible_customer->name}}</td>
                    <td>{{$possible_customer->nome_cliente}}</td>
                    <td>{{$possible_customer->contacto}}</td>
                    <td><a>{{$possible_customer->address}}</a></td>
                    <td>{{$possible_customer->contract_end}}</td>
                    <td>{{$possible_customer->visit_day}}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>


@endsection
















