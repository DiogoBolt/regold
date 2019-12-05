@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/salesman/salesman.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-bar">
    <p class="container-bar_txt">Novo Colaborador</p>
    <div class="container-bar_img">
        <img src="{{ asset('img/salesman.png') }}" />
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div>
                        <img class="salesman-img img-responsive" src="/img/navbar/logoindexcolor.png"/>
                    </div>
                    <form action="/salesman/add"  method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="col-sm-6">
                            <div class="form-group">
                                Tipo de Colaborador: 
                                <select id="selectDistrict" class="form-control" name="UserType">
                                    <option disabled selected value="">Selecione o Tipo de Colaborador</option>
                                    @foreach($UserTypes as $UserType)
                                        <option  class="form-control" value="{{$UserType->name}}">{{$UserType->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                Nome:<input class="form-control"  name="name">
                            </div>
                            <div class="form-group">
                                Morada
                                <br/>
                                <div class="form-group">
                                    Distrito: 
                                    <select id="selectDistrict" class="form-control" name="districts" onchange="listCities(this)" required>
                                        <option disabled selected value="">Selecione o distrito</option>
                                        @foreach($districts as $district)
                                            <option  class="form-control" value="{{$district->id}}">{{$district->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group"> 
                                    Cidade:
                                        <select id="selectCity" class="form-control" name="city" required>
                                            <option disabled selected value="">Selecione a Cidade</option>
                                            <option value="gui">Guimaraes</option> 
                                        </select>
                                </div>
                                <div class="form-group">    
                                    Código Postal:
                                    <br/>
                                     <label>
                                        <input placeholder="7654-321" pattern="[0-9]{4}-[0-9]{3}" class="form-control" name="postal_code" required>
                                    </label>
                                </div>  
                                <div class="form-group">
                                    Rua e número da porta<input class="form-control" placeholder="Morada de Entrega" name="address" required>
                                </div>
                            </div>
                           
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                NIF: <input id="nif" class="form-control" type="number" name="nif">
                            </div>
                            <div class="form-group">
                                Dados de login
                                <br/>
                                Email: <input class="form-control" type="email" name="email">
                            </div>

                            <div class="form-group">
                                Password: <input class="form-control" type="password" name="password">
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-add" onsubmit="return validateForm(this)">
                                <strong>Criar</strong>
                            </button>
                        </div>
        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
