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
    <div class="homePage_container">

        <table class="table">
            <tr>
                <th colspan="2">ENCOMENDAS</th>
            </tr>

            <tr>
                <td>CLIENTES SP</td>
                <td><a href="/clientsOrder/sp" style="color: red">{{$clients_spOrder}}</a> / <a href="/clientsPack/sp">{{$count_sp}}</a></td>
            </tr>
            <tr>
                <td>CLIENTES SP Free</td>
                <td><a href="/clientsOrder/sp free" style="color: red">{{$clients_spfreeOrder}}</a> / <a href="/clientsPack/sp free">{{$count_spfree}}</a></td>
            </tr>
            <tr>
                <td>CLIENTES S</td>
                <td><a href="/clientsOrder/s" style="color: red">{{$clients_sOrder}}</a> / <a href="/clientsPack/s">{{$count_s}}</a></td>
            </tr>
            <tr>
                <td>CLIENTES ST</td>
                <td><a href="/clientsOrder/st" style="color: red">{{$clients_stOrder}}</a> / <a href="/clientsPack/st">{{$count_st}}</a></td>
            </tr>
            <tr>
                <td>CLIENTES T</td>
                <td><a href="/clientsOrder/t" style="color: red">{{$clients_tOrder}}</a> / <a href="/clientsPack/t">{{$count_t}}</a></td>
            </tr>
            <tr>
                <td>TOTAL</td>
                <td><a style="color: red" href="/clientsOrder/all">{{$clientsOrder}}</a> / <a href="/clients">{{$count_clients}}</a></td>
            </tr>
        </table>

        <div class="chart">
            <canvas id="myChart" ></canvas>
        </div>

        <div>
            <table class="table">
                <tr>
                    <th>VALOR COMISSÃO ACUMULADO</th>
                    <th>107.75€</th>
                </tr>
                <tr>
                    <td>VALOR COMISSÃO ESTIMADO</td>
                    <td>707.78€</td>
                </tr>
            </table>
        </div>


        <div style="overflow-x:auto;">
            <table class="table">
                <tr>
                    <th>Nome</th>
                    <th>Pessoa Contacto</th>
                    <th>Contacto</th>
                    <th>Localidade</th>
                    <th>Intervenção</th>
                    <th>Final contrato</th>
                    <th>Hora</th>
                </tr>
                <tr>
                    <td>Cafe Rampa</td>
                    <td>José</td>
                    <td>9191919191</td>
                    <td><a>Requiao</a></td>
                    <td>Cobrança</td>
                    <td>Outubro</td>
                    <td>11:00</td>
                </tr>
            </table>
        </div>

    </div>





                   {{-- <table class="table">
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



                    </table>--}}

                       {{-- <table class="table">
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
                    </table>--}}



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
                        "backgroundColor": "#199400",
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
                        "backgroundColor": "#afd7b3",
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
                "responsive": true,
                "maintainAspectRatio": false,

                "title": {
                    "display": false,
                    "text": "Ad Revenue Comparison 2014-2015",
                    "position": "top",
                    "fullWidth": true,
                    "fontColor": "#aa7942",
                    "fontSize": 30,
                    "fontFamily": ""
                },
                "legend": {
                    "display": true,
                    "fullWidth": true,
                    "position": "top",
                    "align": "left",
                    "labels": {
                        "fontSize": 15,
                        "boxWidth": 25,
                        "padding": 10
                    }
                },
                "scales": {
                    "yAxes": [
                        {
                            "ticks": {
                                "beginAtZero": true,
                                "display": true
                            },
                            "display": true
                        }
                    ],
                    "xAxes": {
                        "0": {
                            "barPercentage": 0.8,
                            "categoryPercentage": 0.5,
                            "ticks": {
                                "display": true,
                                "fontSize": 15,
                            },
                            "display": true,
                            "gridLines": {
                                "display": true,
                                "lineWidth": 1,
                                "drawOnChartArea": false,
                                "drawTicks": true,
                                "tickMarkLength": 12,
                                "zeroLineWidth": 2,
                                "offsetGridLines": true,
                                "color": "#b0adb0",
                                "zeroLineColor": "#b0adb0"
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
                    "backgroundColor": "#000000",
                    "color": "#001009"
                }
            };

            var myChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: options
            });

        }

    </script>














