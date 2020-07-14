@extends('layouts.app')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/client/client-bo.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt" id="demo"></p>
        <div class="container-bar_img">
            <img src="{{ asset('img/clientes.jpg') }}"/>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel">
                    <div class="panel-body table-responsive">

                        <p id="demo"></p>

                        <table class="table">
                            <tr>
                                <th>Id</th>
                                <th>Nome</th>
                                <th>Tecnico HACCP</th>
                                <th>Auditoria</th>
                                <th>Entrar</th>
                                <th>Eliminar</th>
                            </tr>
                            @foreach($clients as $client)

                                    <tr>
                                        <td><a href="/clients/{{$client->id}}">{{$client->regoldiID}}</a></td>
                                        <td><a href="/clients/{{$client->id}}">{{$client->name}}</a></td>
                                        <td>
                                            <div class="form-group">
                                                <select id="selectTechnical" class="form-control" name="technical" {{--onchange="listCities(this)"--}}>
                                                    <option disabled selected value="">Selecione o Técnico HACCP</option>
                                                    @foreach($technicals as $technical)
                                                        <option  class="form-control" value="{{$technical->id}}">{{$technical->name}}</option>
                                                    @endforeach
                                                </select>
                                                <button style="display: inline">Confirmar</button>
                                            </div>
                                        </td>
                                        <td><input type="checkbox" id="checked" value="checked"></td>
                                        <td><a href="/clients/impersonate/{{$client->id}}">Entrar</a></td>
                                        <td>
                                            <button class="btn-del" data-toggle="modal" data-target="#deleteModal"
                                                    data-item="{{ $client }}">Eliminar
                                            </button>
                                        </td>
                                    </tr>

                            @endforeach
                        </table>
                        <a href="/clients/new" class="btn btn-add"><strong>Novo Cliente</strong></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    window.onload = function month() {
        const monthNames = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho",
            "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"
        ];
        const d = new Date();
        document.getElementById("demo").innerHTML='Agenda '+monthNames[d.getMonth()]
    }
</script>

