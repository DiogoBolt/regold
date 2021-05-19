@extends('layouts.app')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/documents/temp-register.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">agenda</p>
        <div class="container-bar_img">
            <img src="{{ asset('img/clientes.jpg') }}"/>
        </div>
    </div>
    <div class="container">

        <div class="row">
            <form method="get" action="/schedule/regolfood" id="history-form">
                <div class="row">
                    <div class="col-sm-2">
                        Ano :
                        <select name="year" class="form-control" required>
                            <option value="" disabled selected>Seleccione Ano</option>
                            @foreach($years as $year)
                                <option value="{{ $year->year }}">
                                    {{ $year->year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-2">
                        Mês :
                        <select name="month" class="form-control" required>
                            <option value="" disabled selected>Seleccione Mês</option>
                            @foreach($months as $idx => $month)
                                @if(date('m') == $idx)
                                    <option value="{{ $idx  }}" selected>
                                        {{ $month }}
                                    </option>
                                @else
                                    <option value="{{ $idx  }}">
                                        {{ $month }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4 text-right">
                        <div class="col-xs-6">
                            <button class="btn btn-add margin-top" type="submit" id="submit-btn" form="history-form">
                                Mostrar histórico
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="col-md-8 col-md-offset-2">
                <div class="panel">
                    <div class="panel-body table-responsive">




                       {{-- <form method="get" action="/clients">
                            <input id="client-search" name="search" class="form-control"
                                   placeholder="Pesquisa de clientes..."/>
                        </form>--}}
                        <script src="{{ URL::asset('/js/validations.js') }}"></script>
                        {{--<a data-toggle="collapse" href="#collapseFilter" role="button"
                           aria-expanded="false" aria-controls="collapseFilter">
                            <strong>Filtrar por cidade</strong>
                        </a>
                        <div class="collapse" id="collapseFilter">
                            <form action="/clients" method="GET" id="filter-form">
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
                        </div>--}}

                        <table class="table">
                            <tr>
                                <th>Id</th>
                                <th>Nome</th>
                                <th>Técnico</th>
                                <th></th>
                            </tr>
                            @foreach($schedule as $client)
                                    <tr>
                                        <td><a href="/clients/{{$client->id}}">{{$client->regoldiID}}</a></td>
                                        <td><a href="/clients/{{$client->id}}">{{$client->name}}</a></td>
                                        <td>
                                            <div>
                                                <select class="dropdown" name="technical" >
                                                    <option disabled value="">Tecnico HACCP</option>
                                                    @foreach($technicals as $technical)
                                                        @if($client->technical == $technical->id)
                                                            <option value="{{$technical->id}}" selected>{{$technical->name}}</option>
                                                        @else
                                                            <option value="{{$technical->id}}">{{$technical->name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td>@if($client->check_s==1)
                                                <input type="checkbox" checked disabled>
                                            @else
                                                <input type="checkbox" disabled>
                                            @endif
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

