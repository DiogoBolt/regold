<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link href="{{ asset('css/orders/order.css') }}" rel="stylesheet">

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel">
                <div class="panel-body table-responsive printall">
                    <div style="text-align: center; margin-bottom: 20px;">
                        <img src="/img/navbar/logoRegolfood.png"/>
                    </div>
                    <div class="col-xs-12">
                        <div class="margin-top table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Área/Equipamento</th>
                                    <th>Dia</th>
                                    <th>Limpo</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->designation}}</td>
                                            <td>{{ $item->day}}</td>
                                            <td>{{'Limpo'}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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