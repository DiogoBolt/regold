
<<<<<<< HEAD
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel">
                <div class="panel-body table-responsive printall">
                    <div style="text-align: center; margin-bottom: 20px;">
                        <img class="imp_logo" src="/img/navbar/logoRegolfood.png"/>
                        <h1 class="title">Registo Qualidade do Óleo ano: </h1>
                    </div>


                        <div id="divFloatRigth">
                            <div>
                                <label class="lblBold" id="date"> {{$details->year}} </label>
                                <label class="lblBold">Ano: </label>
                            </div>
                            <div id="divFloatRigth">
                                <div>
                                    <label class="lblBold" id="date"> {{$details->month}} </label>
                                    <label class="lblBold">Mês: </label>
                                </div>
=======
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="{{ asset('css/orders/order.css') }}" rel="stylesheet">

        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel">
                        <table class="report-container">
                            <thead class="report-header">
                                <tr>
                                    <th class="report-header-cell">
                                        <div style="text-align: center; margin-bottom: 20px;">
                                            <img class="imp_logo" src="/img/navbar/logoRegolfood.png"/>
                                            <div id="divFloatRigth">
                                                <div>
                                                    <label class="lblBold" id="date"> {{$details->year}} </label>
                                                    <label class="lblBold">Ano: </label>
                                                </div>
                                            </div>
                                            <div id="divFloatRigth">
                                                <div>
                                                    <label class="lblBold" id="date"> {{$details->month}} </label>
                                                    <label class="lblBold">Mês: </label>
                                                </div>
                                            </div>
                                            <h1 class="title">Registo Qualidade do Óleo </h1>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
>>>>>>> 47f2338156d9822b6db17411d7288f639fbf42d9

                                <tbody class="report-content">
                                <tr>
                  <td class="report-content-cell">
                                    <div class="col-xs-12">
                                        <div class="margin-top table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>Dia</th>
                                                    <th>Nome do Equipamento</th>
                                                    <th>Nº do Equipamento</th>
                                                    <th>Aspeto</th>
                                                    <th>Troca de Óleo</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($data as $item)
                                                    <tr>
                                                        <td>{{ $item->day}}</td>
                                                        <td>{{ $item->equipment_name}}</td>
                                                        <td>{{ $item->equipment_number}}</td>
                                                        <td>{{ $item->oil_aspect}}</td>
                                                        <td>{{ $item->changeOil?'Sim':'Não'}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->day}}</td>
                                            <td>{{ $item->equipment_name}}</td>
                                            <td>{{ $item->equipment_number}}</td>
                                            <td>{{ $item->oil_aspect}}</td>
                                            <td>{{ $item->changeOil?'Sim':'Não'}}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </div>
        </div>
<<<<<<< HEAD
        </div>
            <footer class="footer_1" id="footer">
                <img class="report_footer" src="{{ URL::to('/') }}/img/footer.png" alt="logo">
            </footer>
        </div>
=======
    <tfoot class="report-footer">
        <tr>
            <td class="report-content-cell">
                <div>
                <footer class="footer_1"id="footer">
                    <img class="report_footer" src="{{ URL::to('/') }}/img/footer3.png" alt="logo">
                </footer>
                </div>
            </td>
        </tr>
    </tfoot>


>>>>>>> 47f2338156d9822b6db17411d7288f639fbf42d9

        <script>
            window.onload = function () {
                setTimeout(window.print, 500);
                setTimeout(function () {
                    window.close();
                }, 500);
            };
        </script>