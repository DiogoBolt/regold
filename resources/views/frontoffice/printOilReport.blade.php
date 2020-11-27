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
                        <h1 class="title">Registo Qualidade do Óleo</h1>
                    </div>
<<<<<<< HEAD
=======
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

{{--                        <h1 class="title">Registo Qualidade do Óleo</h1>--}}

>>>>>>> e36c87b6a24ff5cc5fbf616d65422090d3772f8a
                    <div class="col-xs-12">
                        <div class="margin-top table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Dia</th>
                                    <th>Aspeto</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->day}}</td>
                                            <td>{{ $item->oil_aspect}}</td>
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