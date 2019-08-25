<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link href="{{ asset('css/orders/order.css') }}" rel="stylesheet">

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel">
                    <div class="panel-body table-responsive">
    
                        <div style="text-align: center; margin-bottom: 20px;">
                            <img src="/img/navbar/logoindexcolor.png"/>
                        </div>
    
                        @foreach ($printingData as $item)    
                            <div class="form-group">
                                <b>NOME : </b>{{ $item['client']['name'] }}
                            </div>
    
                            <div class="form-group">
                                <b>MORADA : </b>{{ $item['client']['address'] }}
                            </div>

                            <div class="form-group">
                                <b>REGOLD ID : </b>{{ $item['client']['regoldiID'] }}
                            </div>

                            <div class="form-group">
                                <b>CRIADA A : </b>{{ $item['order']['created_at'] }}
                            </div>

                            <div class="form-group print-checkbox">
                                <b>PREPARADO : </b>
                                <label>
                                    <input type="checkbox" />
                                    <span class="checkmark"></span>
                                </label>
                            </div>

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
                        @endforeach
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
                

    
@endforeach


<script>

    window.onload = function() {
       
        setTimeout(window.print, 500);
        setTimeout(function () { window.close(); }, 500); 
    };

</script>