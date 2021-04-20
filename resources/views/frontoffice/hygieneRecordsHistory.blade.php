@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/documents/temp-register.css') }}" rel="stylesheet">
@endsection

<script src="{{ URL::asset('/js/records.js') }}"></script>

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">
            HISTÓRICO DE HIGIENE
        </p>
        <div class="container-bar_img">
            <img src="/img/haccp_icon.png"/>
        </div>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
            <li class="breadcrumb-item " aria-current="page">Documentos Registos</li>
            <li class="breadcrumb-item active" aria-current="page">Registos de Higiene</li>
            <li class="breadcrumb-item active" aria-current="page">Histórico de Higiene</li>
        </ol>
    </nav>

    {{-- Go Back Button --}}
    <a class="back-btn" href="/frontoffice/records/hygiene">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Registos Higiene</strong></span>
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
                    <div class="col-sm-2">
                        Secção :
                        <select name="clientSection" class="form-control" required>
                            <option value="" disabled selected>Seleccione Secção</option>
                            @foreach($clientSections as $section)
                                <option value="{{ $section->id  }}"{{-- data-type="{{ $thermo->type }}"--}}>
                                    {{ $section->designation }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-2">
                        Frequência :
                        <select name="cleaningFrequency" class="form-control" required>
                            <option value="" disabled selected>Seleccione Frequência</option>
                            @foreach($cleaningFrequency as $clean)
                                <option value="{{ $clean->id  }}"{{-- data-type="{{ $thermo->type }}"--}}>
                                    {{ $clean->designation }}
                                </option>
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
                <table id="myTable" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Item</th>
                        @for($i=1;$i<=30;$i++)
                            <th>{{$i}}</th>
                        @endfor
                    </tr>
                    </thead>
                    <tbody id="table-body"></tbody>
                </table>
            </div>
        </div>
    </div>

    <form action="/frontoffice/records/hygiene/history/print" type="POST" id="print-form">
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
            submitForm(data);
        }

        function submitForm(data) {
            $.ajax({
                type: 'GET',
                url: '/frontoffice/records/hygiene/history/get',
                data,
                success: function (response) {
                    cacheData = [];
                    if (response.length) {
                        data.cleaningFrequency = document.getElementsByName('cleaningFrequency')[0].selectedOptions[0].text;
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


                /* Weird bug happening, had to send each property separately */
                for(i=0;i<response.length;i++) {
                    tableBody.innerHTML +=
                        `<tr>
                            <td>${response[i].designation}</td>
                            <td id="'i"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>`;
                }

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
