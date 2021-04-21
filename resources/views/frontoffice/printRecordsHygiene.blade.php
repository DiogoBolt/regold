<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link href="{{ asset('css/orders/order.css') }}" rel="stylesheet">

<div class="container">
    <div class="row">
        <div class="col-md-13 col-md-offset-0">
            <div class="panel">
                <table class="report-container" width="600px">
                    <thead class="report-header">
                        <tr>
                            <th class="report-header-cell">
                                <div style="text-align: center; margin-bottom: 20px;margin-right: 100px;">
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
                                    <h1 class="title">Registo de Higiene </h1>
                                </div>
                            </th>
                        </tr>
                    </thead>

            <tbody class="report-content">
                <tr>
                    <td class="report-content-cell">
                    <div class="col-xs-12">
                        <div class="margin-top table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Item</th>
                                    @for($i=1;$i<=31;$i++)
                                        <th>{{$i}}</th>
                                    @endfor
                                </tr>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{$item->designation}}</td>
                                            @for($i=1;$i<=31;$i++)
                                                <td></td>
                                            @endfor
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>

            <tfoot class="report-footer">
        <tr>
            <td class="report-content-cell">
                <div>
                <footer class="footer_1" id="footer">
                    <img class="report_footer" src="{{ URL::to('/') }}/img/footer3.png" alt="logo">
                </footer>
                </div>
            </td>
        </tr>
            </tfoot>
                </table>
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