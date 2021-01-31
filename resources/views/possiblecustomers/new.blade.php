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
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="/possiblecustomers/newPossibleCustomer" method="post" >
                        {{ csrf_field() }}

                        <div class="col-sm-6">
                            <div class="form-group">
                                Nome:<input class="form-control" placeholder="Nome" id='ownerName'  name="name">
                            </div>
                            <div class="form-group">
                                Morada: <input class="form-control" name="address" required>
                            </div>
                            <div class="form-group">
                               Empresa Atual: <input  name="current_contract"  >
                            </div>

                            <div class="form-group">
                                Data Final Contrato: <input type="date" name="contract_end"  >
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
</div>
@endsection
