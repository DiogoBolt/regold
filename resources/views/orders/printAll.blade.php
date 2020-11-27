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

                    @foreach ($printingData as $item)
                        <div class="row">
                            <div class="print_details">
                                <div>
                                    <b>NOME : </b>{{ $item['client']['name'] }}
                                </div>
                                <div>
                                    <b>MORADA
                                        : </b>{{ $item['client']['address'] == null ? $item['client']['address'] : $item['client']['invoice_address'] }}
                                </div>
                                <div>
                                    <b>METODO PAGAMENTO : </b>{{ $item['client']['payment_method'] }}
                                </div>
                                <div>
                                    <b>CONTA CORRENTE : </b>{{ $item['client']['total'] }}
                                </div>
                            </div>
                            <div class="print_details">
                                <div>
                                    <b>REGOLD ID : </b>{{ $item['client']['regoldiID'] }}
                                </div>
                                <div>
                                    <b>CRIADA A : </b>{{ $item['order']['created_at'] }}
                                </div>
                                <div>
                                    <b>TOTAL : </b>{{ $item['order']['total'] }}
                                </div>
                                <div class=" print-checkbox">
                                    <b>PREPARADO : </b>
                                    <label>
                                        <input type="checkbox"/>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <table class="table table-bordered">
                                <tr>
                                    <th>Nome</th>
                                    <th>Quantidade</th>
                                    <th>Preço/Unidade</th>
                                    <th>Total</th>
                                </tr>
                                @foreach( $item['line_items'] as $item)
                                    <tr>
                                        <td>{{$item->product->name}}</td>
                                        <td>{{$item->amount}}</td>
                                        <td>{{$item->total/$item->amount}}€</td>
                                        <td>{{number_format($item->total,2)}}€</td>
                                    </tr>
                                @endforeach

                            </table>

                            <hr>
                        </div>
                    @endforeach
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