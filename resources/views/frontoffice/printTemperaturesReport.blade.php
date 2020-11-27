<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link href="{{ asset('css/orders/order.css') }}" rel="stylesheet">

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel">
                <div class="panel-body table-responsive printall">
                    <div style="text-align: center; margin-bottom: 20px;">
                        <img class="imp_logo" src="/img/navbar/logoRegolfood.png"/>
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
                        </div>

                        <h1 class="title">Registo de Temperatura</h1>

                    <div class="col-xs-12">
                            <h2>{{ $details->type . ' ( imei : ' . $details->imei . ' )' }}</h2>
                            <h3 style="color: red !important;">Período : {{ $details->month . '/' . $details->year }}</h3>
                    </div>
                    <div class="col-xs-12">
                        <div class="margin-top table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Dia</th>
                                    <th>Manhã (ºC)</th>
                                    <th>Tarde (ºC)</th>
                                    <th>Obs.</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->day}}</td>
                                            <td style="color:{{$item->tempCheck->morningTemp ? 'red !important' : ''}}">{{ $item->morning_temp ?? 'Sem dados'}}</td>
                                            <td style="color:{{$item->tempCheck->afternoonTemp ? 'red !important' : ''}}">{{ $item->afternoon_temp ?? 'Sem dados'}}</td>
                                            <td class="text-center">
                                                <div class="col-sm-9">{{ $item->observations ? $item->observations : ''  }}</div>
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
            <footer class="footer_1"id="footer">
                <img class="report_footer" src="{{ URL::to('/') }}/img/footer.png" alt="logo">
            </footer>
    </div>
</div>

<script>
        window.onload = function () {
            setTimeout(window.print, 500);
            setTimeout(function () {
                window.close();
            }, 500);
        };
</script>