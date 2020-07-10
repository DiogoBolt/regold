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
                                <option value="{{ $idx  }}">
                                    {{ $month }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4">
                        Tipo :
                        <select name="imei" class="form-control" required>
                            <option value="" disabled selected>Seleccione Tipo</option>
                            @foreach($clientThermos as $thermo)
                                <option value="{{ $thermo->imei  }}" data-type="{{ $thermo->type }}">
                                    {{ $thermo->id }} | {{ $thermo->type === 1 ? 'Refrigeração' : 'Congelação' }}
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
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Dia</th>
                        <th>Manhã (ºC)</th>
                        <th>Tarde (ºC)</th>
                        <th>Obs.</th>
                    </tr>
                    </thead>
                    <tbody id="table-body"></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="obsModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">x</button>
                    <h4 class="modal-title">Observações</h4>
                </div>
                <div class="modal-body">
                    Observação:
                    <textarea id="observation" class="form-control" rows="10" required></textarea>
                </div>
                <div class="modal-footer">
                    <h4 id="update" class="pull-left hidden"></h4>
                    <button type="button" class="btn btn-add" id="add-obs">
                        <strong>Adicionar</strong>
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <strong>Cancelar</strong>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <form action="/frontoffice/records/temperatures/history/print" type="POST" id="print-form">
        <input type="hidden" name="printReport[]" value="" id="print-items"/>
    </form>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const historyForm = document.getElementById('history-form');
        const noResults = document.getElementById('no-results');
        const table = document.getElementById('results-table');
        const tableBody = document.getElementById('table-body');
        const update = document.getElementById('update');
        const printBtn = document.getElementById('print-btn');
        const addBtn = $('#add-obs');
        let cacheData = [];
        const tempInterval = {
            1: [0, 5],
            2: [-18, 0]
        };

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
                url: '/frontoffice/records/temperatures/history/get',
                data,
                success: function (response) {
                    if (response.length) {
                        data.type = document.getElementsByName('imei')[0].selectedOptions[0].text;
                        cacheData.push(data, response);
                        buildResponse(response);
                    } else {
                        noResults.innerHTML = '<h2 class="text-center margin-top">Sem dados para o filtro fornecido.</h2>';
                    }
                },
                error: function () {
                    noResults.innerHTML = '<h2 class="text-center margin-top">Ocorreu um erro, por favor, tente mais tarde.</h2>';
                }
            });
        }

        function buildResponse(response) {
            table.classList.remove('hidden');

            response.forEach(data => {
                const morningTemp = data.morning_temp ? parseFloat(data.morning_temp).toFixed(2) : 'Sem dados';
                const afternoonTemp = data.afternoon_temp ? parseFloat(data.afternoon_temp).toFixed(2) : 'Sem dados';
                const tempCheck = checkIfHigh(morningTemp, afternoonTemp);
                /* Weird bug happening, had to send each property separately */
                const btn = `<button class="btn btn-add" data-toggle="modal" data-target="#obsModal" data-obs="${data.observations}" data-id="${data.id}">Observação</button>`;

                tableBody.innerHTML += `
                    <tr>
                        <td>${data.day}</td>
                        <td class="${tempCheck.morningTemp}">${morningTemp}</td>
                        <td class="${tempCheck.afternoonTemp}">${afternoonTemp}</td>
                        <td class="text-center">
                            <div class="col-sm-9">${data.observations ? data.observations : ''}</div><div class="col-xs-3">${btn}</div>
                        </td>
                    </tr>
                `;
            });
        }

        function checkIfHigh(morningTemp, afternoonTemp) {
            const imeiSelect = historyForm.elements.imei;
            const selectedOptionType = imeiSelect[imeiSelect.selectedIndex].getAttribute('data-type');
            const morningCheck = morningTemp < tempInterval[selectedOptionType][0] || morningTemp > tempInterval[selectedOptionType][1];
            const afternoonCheck = afternoonTemp < tempInterval[selectedOptionType][0] || afternoonTemp > tempInterval[selectedOptionType][1];
            let check = {};
            check.morningTemp = morningCheck ? 'high' : '';
            check.afternoonTemp = afternoonCheck ? 'high' : '';

            return check;
        }

        $('#obsModal').on('show.bs.modal', function (event) {
            const item = $(event.relatedTarget);
            const obs = item.data('obs');
            const id = item.data('id');
            $(this).find('#observation').val(`${obs ? obs : ''}`);

            addBtn.on('click', () => saveObservation(id));
        });

        function saveObservation(id) {
            const obs = document.getElementById('observation').value;
            addBtn.addClass('disabled');
            $.ajax({
                type: 'POST',
                url: '/frontoffice/records/temperatures/history/comment',
                data: {id, obs},
                success: function (response) {
                    if (response.success) {
                        update.innerText = response.success;
                        update.style.color = 'green';
                        update.classList.remove('hidden');

                        setTimeout(
                            document.getElementById('submit-btn').click(),
                            addBtn.removeClass('disabled')
                            , 2000);
                    } else {
                        update.innerText = response.error;
                        update.style.color = 'red';
                        update.classList.remove('hidden');
                    }
                }
            });
        }

        $("#obsModal").on("hidden.bs.modal", function () {
            addBtn.unbind('click');
            addBtn.removeClass('disabled');
            update.classList.add('hidden');
        });

        function printReport() {
            if(cacheData.length > 0) {
                document.getElementById("print-items").value = JSON.stringify(cacheData);
                document.getElementById("print-form").submit();
            }
        }

    }, false);
</script>
