@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/documents/temp-register.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">
            HISTÓRICO DE TEMPERATURAS
        </p>
        <div class="container-bar_img">
            <img src="/img/haccp_icon.png"/>
        </div>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
            <li class="breadcrumb-item" aria-current="page">Documentos Registos</li>
            <li class="breadcrumb-item" aria-current="page">Temperaturas</li>
            <li class="breadcrumb-item active" aria-current="page">Histórico Temperaturas</li>
        </ol>
    </nav>

    {{-- Go Back Button --}}
    <a class="back-btn" href="/frontoffice/records/temperatures">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Temperaturas</strong></span>
    </a>

    <div class="container">
        <div class="col-xs-12">
            <form method="get" action="javascript:void(0);" id="history-form">
                <div class="col-sm-5">
                    Mês :
                    <select name="month" class="form-control" required>
                        <option value="" disabled selected>Seleccione Mês</option>
                        @foreach($months as $idx => $month)
                            <option value="{{ $idx  }}">
                                {{ $month }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-5">
                    Tipo :
                    <select name="imei" class="form-control" required>
                        <option value="" disabled selected>Seleccione Tipo</option>
                        @foreach($clientThermos as $thermo)
                            <option value="{{ $thermo->imei  }}">
                                {{ $thermo->id }} | {{ $thermo->type === 1 ? 'Refrigeração' : 'Congelação' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-add margin-top" type="submit">Mostrar histórico</button>
                </div>
            </form>
        </div>
        <div class="col-xs-12">
            <div id="results"></div>
            <div id="results-table" class="hidden">
                <table>
                    <tr>
                        <th>Dia</th>
                        <th>Manhã</th>
                        <th>Tarde</th>
                        <th>Obs.</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const historyForm = document.getElementById('history-form');
        const resultsDiv = document.getElementById('results');
        const table = document.getElementById('results-table');
        historyForm.addEventListener('submit', event => handleSubmit(event));

        function handleSubmit(event) {
            event.preventDefault();
            resultsDiv.innerHTML = '';
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
                url: '/frontoffice/records/temperatures/history/get',
                data,
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                success: function (response) {
                    if (response.length) {
                        buildResponse(response);
                    } else {
                        resultsDiv.innerHTML = '<h2 class="text-center margin-top">Sem dados para o filtro fornecido.</h2>';
                    }
                },
                error: function () {
                    resultsDiv.innerHTML = '<h2 class="text-center margin-top">Ocorreu um erro, por favor, tente mais tarde.</h2>';
                }
            });
        }

        function buildResponse(response) {
            table.classList.remove('hidden');
            console.log(response);

        }

    }, false);
</script>
