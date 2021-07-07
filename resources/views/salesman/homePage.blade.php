@extends('layouts.app')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/salesman/homepage.css') }}" rel="stylesheet">
    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>

@endsection

@section('content')
<div class="container-bar">
    <p class="container-bar_txt">Home</p>
    <div class="container-bar_img">
        <img src="{{ asset('img/encomendas.jpg') }}" />
    </div>
</div>
<div  class="container">
    <div  class="row">
            <div  class="panel">
                <div  class="panel-body table-responsive">
                    
                    <div class="divChart1">
                        <canvas id="myChart" style="background-color:rgba(255,255,255,1.00);border-radius:0px; width:100%;height:50%;padding-left:0px;padding-right:0px;padding-top:0px;padding-bottom:0px"></canvas>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="2">ENCOMENDAS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>CLIENTES SP</td>
                                <td><a href="/clients" style="color: red">{{$clients_spOrder}}</a> / <a>{{$clients_sp}}</a></td>
                            </tr>
                            <tr>
                                <td>CLIENTES SP Free</td>
                                <td><a href="/clients" style="color: red">{{$clients_spfreeOrder}}</a> / <a>{{$clients_spfree}}</a></td>
                            </tr>
                            <tr>
                                <td>CLIENTES S</td>
                                <td><a href="/clients" style="color: red">{{$clients_sOrder}}</a> / <a>{{$clients_s}}</a></td>
                            </tr>
                            <tr>
                                <td>CLIENTES ST</td>
                                <td><a href="/clients" style="color: red">{{$clients_stOrder}}</a> / <a>{{$clients_st}}</a></td>
                            </tr>
                            <tr>
                                <td>CLIENTES T</td>
                                <td><a href="/clients" style="color: red">{{$clients_tOrder}}</a> / <a>{{$clients_t}}</a></td>
                            </tr>
                            <tr>
                                <td>TOTAL</td>
                                <td><a href="/clients" style="color: red">{{$clientsOrder}}</a> / <a>{{$clients}}</a></td>
                            </tr>
                        </tbody>
                    </table>

                    <table  id="table" class="table">
                        <thead>
                            <tr>
                                <td>Nome</td>
                                <td>Pessoa Contacto</td>
                                <td>Contacto</td>
                                <td>Localidade</td>
                                <td>Intervenção</td>
                                <td>Final contrato</td>
                                <td>Hora</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Cafe Rampa</td>
                                <td>José</td>
                                <td>9191919191</td>
                                <td><a>Requiao</a></td>
                                <td>Cobrança</td>
                                <td>Outubro</td>
                                <td>11:00</td>
                            </tr>
                        </tbody>
                    </table>


                    <table class="table">
                        <thead>
                            <tr>
                                <td>VALOR COMISSÃO ACUMULADO</td>
                                <td>107.75€</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>VALOR COMISSÃO ESTIMADO</td>
                                <td>707.78€</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection


    <script>
        window.onload = function () {
            var ctx = document.getElementById('myChart').getContext('2d');
            var data = {
                "labels": [
                    "Vendas",
                    "Cobrança",
                    "Clientes Novos"
                ],
                "datasets": [
                    {
                        "label": "Real",
                        "backgroundColor": "#aaadff",
                        "fill": true,
                        "data": [
                            "230",
                            "250",
                            "240"
                        ],
                        "borderColor": "#ffffff",
                        "borderWidth": "1"
                    },
                    {
                        "label": "Objetivo",
                        "backgroundColor": "#407aaa",
                        "fill": true,
                        "data": [
                            "200",
                            "300",
                            "280"
                        ]
                    }
                ]
            };
            var options = {
                "title": {
                    "display": false,
                    "text": "Ad Revenue Comparison 2014-2015",
                    "position": "top",
                    "fullWidth": true,
                    "fontColor": "#aa7942",
                    "fontSize": 16,
                    "fontFamily": ""
                },
                "legend": {
                    "display": true,
                    "fullWidth": true,
                    "position": "top",
                    "labels": {
                        "boxWidth": 50,
                        "padding": 20
                    }
                },
                "scales": {
                    "yAxes": [
                        {
                            "ticks": {
                                "beginAtZero": true,
                                "display": true
                            },
                            "gridLines": {
                                "display": false,
                                "lineWidth": 2,
                                "drawOnChartArea": true,
                                "drawTicks": true,
                                "tickMarkLength": 1,
                                "offsetGridLines": true,
                                "zeroLineColor": "#942192",
                                "color": "#d6d6d6",
                                "zeroLineWidth": 2
                            },
                            "scaleLabel": {
                                "display": false,
                                "labelString": "USD in Millions",
                                "fontSize": 17
                            },
                            "display": true
                        }
                    ],
                    "xAxes": {
                        "0": {
                            "ticks": {
                                "display": true,
                                "fontSize": 14,
                                "fontStyle": "italic"
                            },
                            "display": true,
                            "gridLines": {
                                "display": false,
                                "lineWidth": 2,
                                "drawOnChartArea": false,
                                "drawTicks": true,
                                "tickMarkLength": 12,
                                "zeroLineWidth": 2,
                                "offsetGridLines": true,
                                "color": "#942192",
                                "zeroLineColor": "#942192"
                            },
                            "scaleLabel": {
                                "fontSize": 16,
                                "display": false,
                                "fontStyle": "normal"
                            }
                        }
                    }
                },
                "tooltips": {
                    "enabled": true,
                    "mode": "label",
                    "caretSize": 10,
                    "backgroundColor": "#00fa92"
                }
            };

            var myChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: options
            });

        }

    </script>














