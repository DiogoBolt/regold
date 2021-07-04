@extends('layouts.app')
   
@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/client/client-add.css') }}" rel="stylesheet">
@endsection

@section('content')
<script src="{{ URL::asset('/js/validations.js') }}"></script>
<div class="container-bar">
    <p class="container-bar_txt">Novo Possível Cliente</p>
    <div class="container-bar_img">
        <img src="{{ asset('img/add-user.png') }}" />
    </div>
</div>
<div class="container">
    <div class="row">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="/possiblecustomers/newPossibleCustomer" method="post" >
                        {{ csrf_field() }}

                        <div class="col-sm-6">
                            <div class="form-group">
                                Estabelecimento:<input class="form-control" placeholder="Nome Estabelecimento" id='ownerName'  name="name" required>
                            </div>
                            <div class="form-group">
                                Nome:<input class="form-control" placeholder="Nome Cliente" id='ownerName'  name="nome_cliente" required>
                            </div>
                            <div class="form-group">
                                Contacto:<input class="form-control" placeholder="Contacto Cliente" id='ownerName'  name="contacto" required>
                            </div>
                            <div class="form-group">
                                Morada:<input class="form-control" placeholder="Morada Cliente" id='ownerName'  name="address" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                Concorrente: <input class="form-control" placeholder="Nome Concorrente" name="competitor" >
                            </div>
                            <div class="form-group">
                                Pack sugerido: <input class="form-control" placeholder="Sugerir pack" name="suggested_pack" >
                            </div>
                            <div class="form-group">
                                Final Contrato: <input type="date" class="form-control" placeholder="Nome"  name="contract_end" required >
                            </div>
                            <div class="form-group">
                                Data Visita: <input type="date" class="form-control" placeholder="Nome" name="visit_day"  >
                            </div>


                        </div>
                        <div>
                        <button class="btn btn-add" >Criar</button>
                    </div>
                </form>
                </div>
            </div>
    </div>
</div>
@endsection
