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

                        <a data-toggle="collapse" href="#collapseFilter" role="button"
                           aria-expanded="false" aria-controls="collapseFilter">
                            <strong>Filtrar por cidade</strong>
                        </a>

                        <div class="collapse" id="collapseFilter">
                            <form action="/clients/regolfood" method="GET" id="filter-form">
                                <div class="card card-body">
                                    <label for="district-filter">Distrito</label>
                                    <select class="form-control" id="city-filter"  name="district" onchange="listCities(this)">
                                        <option value="" selected disabled>Seleccione o Distrito</option>
                                        @foreach($districts as $district)
                                            <option  class="form-control" value="{{$district->id}}">{{$district->name}}</option>
                                        @endforeach
                                    </select>
                                    <label for="city-filter">Cidade</label>
                                    <select id="selectCityInvoice" class="form-control" name="cityInvoice" >
                                        <option disabled selected value="">Selecione a Cidade</option>
                                    </select>
                                </div>
                                <button class="btn" type="submit" form="filter-form">Filtrar</button>
                            </form>
                        </div>

                        <table class="table table-bordered">
                            <tr>
                                <th>Id</th>
                                <th>Nome</th>
                                <th>Cidade</th>
                                <th>Técnico HACCP</th>
                              {{--  <th>Auditoria</th>--}}
                            </tr>
                            @foreach($clients as $abc)
                                    <tr>
                                        <td><a href="/clients/{{$abc->id}}">{{$abc->regoldiID}}</a></td>
                                        <td><a href="/clients/{{$abc->id}}">{{$abc->name}}</a></td>
                                       <td>@foreach($cities as $city)
                                                @if( $city->id == $abc->city)
                                                    {{$city->name}}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            <div>
                                                <select id="{{$abc->id}}" class="dropdown" name="technical" >
                                                    <option disabled selected value="">Selecione o Técnico HACCP</option>
                                                    @foreach($technicals as $technical)
                                                        <option  class="form-control" value="{{$technical->id}}">{{$technical->name}}</option>
                                                    @endforeach
                                                </select>
                                                <button  class="btn-success" id="{{$abc->id}}" onclick="confirm(this.id)" style="display: inline-flex">Confirmar</button>
                                            </div>
                                        </td>
                                    </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form action="/clients/regolfood" method="GET" {{--id="filter-form"--}}>
                    Mês :
                    <select id="current_month" name="month" class="form-control" required>
                        <option value="" disabled selected>Seleccione Mês</option>
                        @foreach($months as $idx => $month)
                            <option value="{{ $idx  }}">
                                {{ $month }}
                            </option>
                        @endforeach
                    </select>
                    <button  type="submit" id="submit-btn">
                        Mostrar Agendamentos
                    </button>
                </form>

                <div class="panel">
                    <div class="panel-body table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Id</th>
                                <th>Nome</th>
                                <th>Cidade</th>
                                <th>Técnico HACCP</th>
                                <th>Auditoria</th>
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
                                    <td>
                                        @foreach($technicals as $technical)
                                            @if( $technical->id == $scheduledClient->technical)
                                                {{$technical->name}}
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
        /*$("#current_month").val($idx=monthNames[d.getMonth()]);*/
    }


    function confirm(id) {

        var technical=document.getElementById(id).value;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: "/schedule/regolfood/save/"+id,
            data: {technical}
        }).then(
            window.location.reload()
        );
    }

</script>

