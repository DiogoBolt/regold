@extends('layouts.app')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/client/client-add.css') }}" rel="stylesheet">
@endsection

@section('content')
    <script src="{{ URL::asset('/js/validations.js') }}"></script>
    <div class="container-bar">
        <p class="container-bar_txt">Novo Cliente</p>
        <div class="container-bar_img">
            <img src="{{ asset('img/add-user.png') }}" />
        </div>
    </div>
    <div class="container">
        <div class="row">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="/possiblecustomers/edit/{{$possiblecustomer->id}}" method="post" >
                            {{ csrf_field() }}

                            <div class="col-sm-6">
                                <div class="form-group">
                                    Estabelecimento:<input class="form-control" placeholder="Nome Estabelecimento" id='ownerName'  value="{{$possiblecustomer->name}}" name="name" required>
                                </div>
                                <div class="form-group">
                                    Nome:<input class="form-control" placeholder="Nome Cliente" id='ownerName'  value="{{$possiblecustomer->nome_cliente}}" name="nome_cliente" required>
                                </div>
                                <div class="form-group">
                                    Contacto:<input class="form-control" placeholder="Contacto Cliente" id='ownerName' value="{{$possiblecustomer->contacto}}" name="contacto" required>
                                </div>
                                <div class="form-group">
                                    Morada:<input class="form-control" placeholder="Morada Cliente" id='ownerName' value="{{$possiblecustomer->address}}" name="address" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    Concorrente: <input class="form-control" placeholder="Nome Concorrente" value="{{$possiblecustomer->competitor}}" name="competitor">
                                </div>
                                <div class="form-group">
                                    Pack Sugerido: <input class="form-control" placeholder="Sugerir Pack" value="{{$possiblecustomer->suggested_pack}}" name="suggested_pack" >
                                </div>
                                <div class="form-group">
                                    Final Contrato: <input class="form-control"  type="date" name="contract_end"  value="{{date('Y-m-d', strtotime($possiblecustomer->contract_end))}}" required>
                                </div>

                                <div class="form-group">
                                    Data Visita   : <input class="form-control"  type="date" name="visit_day"  value="{{date('Y-m-d', strtotime($possiblecustomer->visit_day))}}" >
                                </div>

                            </div>
                            <div>
                                <button class="btn btn-add" >Editar</button>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </div>
@endsection
