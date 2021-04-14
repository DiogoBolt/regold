@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/documents/temp-register.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">
            HISTÓRICO DE ENTRADA DE PRODUTO
        </p>
        <div class="container-bar_img">
            <img src="/img/haccp_icon.png"/>
        </div>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
            <li class="breadcrumb-item " aria-current="page">Documentos Registos</li>
            <li class="breadcrumb-item active" aria-current="page">Entrada de Produto</li>
            <li class="breadcrumb-item active" aria-current="page">Histórico Entrada de Produto</li>
        </ol>
    </nav>

    {{-- Go Back Button --}}
    <a class="back-btn" href="/frontoffice/records/insertProduct">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Entrada Produto</strong></span>
    </a>

    <div class="container">
        <div class="col-xs-12">
            <form method="get" action="javascript:void(0);" id="history-form">
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
                        <div class="col-xs-6">
                            <button class="btn btn-add margin-top" type="button" id="print-btn">
                                Imprimir Relatório
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-xs-12">
            <div id="no-results"></div>
            <div id="results-table" class="hidden margin-top table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Dia</th>
                        <th>Produto</th>
                        <th>Fornecedores</th>
                        <th>Fatura/Guia</th>
                        <th>Temperatura</th>
                        <th>Limpeza</th>
                        <th>Estado</th>
                        <th>Embalagem</th>
                        <th>Rotulagem</th>
                        <th>Medidas Corretivas</th>
                        <th>Foto</th>
                    </tr>
                    </thead>
                    <tbody id="table-body"></tbody>
                </table>
            </div>
        </div>
    </div>

    <form action="/frontoffice/records/insertProduct/history/print" type="POST" id="print-form">
        <input type="hidden" name="printReport[]" value="" id="print-items"/>
    </form>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const historyForm = document.getElementById('history-form');
        const noResults = document.getElementById('no-results');
        const table = document.getElementById('results-table');
        const tableBody = document.getElementById('table-body');

        const printBtn = document.getElementById('print-btn');

        historyForm.addEventListener('submit', event => handleSubmit(event));
        printBtn.addEventListener('click', () => printReport(event));

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
            console.log(data)
            submitForm(data);
        }

        function submitForm(data) {
            $.ajax({
                type: 'GET',
                url: '/frontoffice/records/insertProduct/history/get',
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
                tableBody.innerHTML += `
                    <tr>
                        <td>${data.day}</td>
                        <td>${data.product}</td>
                        <td>${data.provider}</td>
                        <td>${data.fatura_guia}</td>
                        <td>${data.temperature}</td>
                        <td>${data.cleaning}</td>
                        <td>${data.product_status}</td>
                        <td>${data.package}</td>
                        <td>${data.label}</td>
                        <td>${data.observations}</td>
                        <td><a href="/uploads/records/${data.image}">${data.image}</a></td>
                    </tr>
                `;
            });

            cacheData.push(response);
        }

        function printReport() {
            if(cacheData.length > 0) {
                document.getElementById("print-items").value = JSON.stringify(cacheData);
                document.getElementById("print-form").submit();
            }
        }

    }, false);
</script>
