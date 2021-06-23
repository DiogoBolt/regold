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
            <form method="get" action="/schedule/haccp" id="schedule-form">
                <div class="row">
                    <div class="col-sm-2">
                        Ano :
                        <select name="year" class="form-control" required>
                            <option value="" disabled selected>Seleccione Ano</option>
                            @foreach($years as $year)
                                @if(date('Y') == $year->year)
                                    <option value="{{ $year->year }}" selected>
                                        {{ $year->year }}
                                    </option>
                                @else
                                <option value="{{ $year->year }}">
                                    {{ $year->year }}
                                </option>
                                @endif
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
                            <button class="btn btn-add margin-top" type="submit" id="submit-btn" form="schedule-form">
                                Mostrar Agenda
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="col-md-8 col-md-offset-2">
                        <script src="{{ URL::asset('/js/validations.js') }}"></script>
                        <div class="col-xs-12">
                            <div id="no-results"></div>
                            <div id="results-table" {{--class="hidden margin-top table-responsive"--}}>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nome</th>
                                        <th>Técnico</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody id="table-body">
                                    @foreach($items as $client)
                                        <tr>
                                            <td><a href="/clients/{{$client->id}}">{{$client->regoldiID}}</a></td>
                                            <td><a href="/clients/{{$client->id}}">{{$client->name}}</a></td>
                                            <td>
                                                <div>
                                                    <select class="dropdown" name="technical" onchange="sendPost({{$client->id}}, this.value)">
                                                        <option disabled value="">Tecnico HACCP</option>
                                                        @foreach($technicals as $technical)
                                                            @if($client->technical == $technical->id)
                                                                <option value="{{$technical->id}}" selected>{{$technical->name}}</option>
                                                            @else
                                                                <option value="{{$technical->id}}" >{{$technical->name}}</option>
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
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
    </div>

@endsection
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>
<script>
    function sendPost(idSchedule,idTechnical)
    {
        $.ajax({
            type: "POST",
            url: "/editTechnical",
            data: {
                "_token": "{{ csrf_token() }}",
                idSchedule: idSchedule, // < note use of 'this' here
                idTechnical: idTechnical
            },
            success: function(result) {
                window.location.reload()
            },
            error: function(result) {
                alert('error');
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const historyForm = document.getElementById('schedule-form');
        const noResults = document.getElementById('no-results');
        const table = document.getElementById('results-table');
        const tableBody = document.getElementById('table-body');

        historyForm.addEventListener('submit', event => handleSubmit(event));

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function handleSubmit(event) {
            event.preventDefault();
            noResults.innerHTML = '';
            tableBody.innerHTML = '';
            table.classList.add('hidden');

            let data = {};
            Object.keys(historyForm.elements).forEach(key => {
                const element = historyForm.elements[key];
                if (element.type !== "submit") {
                    data[element.name] = element.value;
                }
            });
            submitForm(data);
        }

        function submitForm(data) {

            $.ajax({
                type: 'GET',
                url: '/schedule/haccp/get',
                data,
                success: function (response) {
                    cacheData = [];
                    if (response.length) {
                        cacheData.push(data);
                        buildResponse(response);
                    } else {
                        noResults.innerHTML = '<h2 class="text-center margin-top">Sem dados para o filtro fornecido.</h2>';
                    }
                },
                error: function () {
                    cacheData = [];
                    noResults.innerHTML = '<h2 class="text-center margin-top">Ocorreu um erro, por favor, tente mais tarde.</h2>';
                }
            });
        }
        function buildResponse(response) {
            table.classList.remove('hidden');

            response.forEach(data => {
                /* Weird bug happening, had to send each property separately */
                if(data.check_s==1){
                    tableBody.innerHTML += `
                    <tr>
                        <td><a href="/clients/${data.id}">${data.regoldiID}</a></td>
                        <td><a href="/clients/${data.id}">${data.name}</a></td>
                        <td><div>
                                                    <select class="dropdown" name="technical" onchange="sendPost(${data.id}, this.value)">
                                                        <option disabled value="">Tecnico HACCP</option>

                                                    </select>
                                                </div></td>
                        <td><input type="checkbox" checked disabled></td>
                    </tr>`;
                }else{
                    tableBody.innerHTML += `
                    <tr>
                        <td><a href="/clients/${data.id}">${data.regoldiID}</a></td>
                        <td><a href="/clients/${data.id}">${data.name}</a></td>
                        <td><div>
                               <select class="dropdown" name="technical" onchange="sendPost(${data.id}, this.value)">
                                   <option disabled value="">Tecnico HACCP</option>
                                </select>
                            </div>
                        </td>
                        <td><input type="checkbox" disabled></td>
                    </tr>`;
                }
            });
            cacheData.push(response);
        }
    }, false);

</script>

