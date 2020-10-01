@extends('layouts.app')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/client/client-bo.css') }}" rel="stylesheet">



@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt" id="demo"></p>
        <div class="container-bar_img">
            <img src="{{ asset('img/index/icon4.png') }}"/>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel">
                    <div class="panel-body table-responsive">

                        <p id="demo"></p>

                        <script src="{{ URL::asset('/js/validations.js') }}"></script>




                        <input id="datetimepicker" type="text" >

                        <table class="table table-bordered">
                            <tr>
                                <th>Id</th>
                                <th>Nome</th>
                                <th>Cidade</th>
                                <th>Auditoria</th>
                                <th>Agendar</th>
                                <th>Obs.</th>
                            </tr>
                            @foreach($scheduledClients as $scheduledClient)
                                <tr>
                                    <td><a href="/clients/{{$scheduledClient->id}}">{{$scheduledClient->regoldiID}}</a></td>
                                    <td><a href="/clients/{{$scheduledClient->id}}">{{$scheduledClient->name}}</a></td>
                                    <td>
                                        @foreach($cities as $city)
                                            @if($scheduledClient->city==$city->id)
                                                {{$city->name}}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>@if($scheduledClient->check_s==1)
                                            <input type="checkbox" checked disabled>
                                        @else
                                            <input type="checkbox" disabled>
                                        @endif
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                        <select class="form-control" name="obs">
                                            <option disabled selected value="">Selecione a Ação</option>
                                            <option value="Cliente não atendeu">Cliente não atendeu</option>
                                            <option value="Cliente desmarcou">Cliente desmarcou</option>
                                            <option value="Cliente Fechou">Cliente Fechou</option>
                                            <option value="Cliente de férias">Cliente de férias</option>
                                            <option value="Outro">Outro</option>
                                        </select>
                                        <button  class="btn-success" onclick="confirm(this.id)" style="display: inline-flex">Confirmar</button>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
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
