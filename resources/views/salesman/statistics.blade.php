@extends('layouts.app')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/salesman/statistics.css') }}" rel="stylesheet">
    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>

@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">Estatísticas</p>
        <div class="container-bar_img">
            <img src="{{ asset('img/encomendas.jpg') }}" />
        </div>
    </div>

    <div  class="container">
        <div class="charts_container">
            <div>
                <div>
                    <p class="title" style="font-size: 16px"> acumulado mensal </p>
                </div>
                <canvas id="myChart" ></canvas>
            </div>
            <div>
                <div>
                    <p class="title" style="font-size: 16px"> acumulado anual </p>
                </div>
                <canvas id="myChart2" ></canvas>
            </div>
        </div>

        <div>
            <p class="title" style="font-size: 16px"> comissões </p>
        </div>

        <div class="statisticsTable_container">
            <div>
                <table class="table">
                    <tr>
                        <th style="background-color:#62B873;">VALOR ACUMULADO MENSAL</th>
                        <th style="background-color:#62B873;">{{$commissionByMonth[0]}}€</th>
                    </tr>
                    <tr>
                        <td>VALOR OBJETIVO ESTIMADO</td>
                        <td>{{$commissionByMonth[1]}}€</td>
                    </tr>
                </table>
            </div>

            <div>
                <table class="table">
                    <tr>
                        <th style="background-color:#E9824E;">VALOR ACUMULADO ANUAL</th>
                        <th style="background-color:#ea7f4f;">{{$commissionByYear[0]}}€</th>
                    </tr>
                    <tr>
                        <td>VALOR OBJETIVO ESTIMADO</td>
                        <td>{{$commissionByYear[1]}}€</td>
                    </tr>
                </table>
            </div>

            <div>
                <table class="table">
                    <tr>
                        <th style="background-color:#EE9C15;">MELHOR MÊS VENDAS</th>
                        <th style="background-color:#e59c1f;">{{$bestMonthSales}}</th>
                    </tr>
                    <tr>
                        <td>MELHOR MÊS COBRANÇA</td>
                        <td>{{$bestMonthPaid}}</td>
                    </tr>
                </table>
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
                    "backgroundColor": "#5CA86A",
                    "fill": true,
                    "data": [
                        "{{$real_month[0]}}",
                        "{{$real_month[1]}}",
                        "{{$real_month[2]}}"
                    ],
                    "borderColor": "#ffffff",
                    "borderWidth": "1"
                },
                {
                    "label": "Objetivo",
                    "backgroundColor": "#ABDAB5",
                    "fill": true,
                    "data": [
                        "{{$target_month[0]}}",
                        "{{$target_month[1]}}",
                        "{{$target_month[2]}}"
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

        var ctx2 = document.getElementById('myChart2').getContext('2d');
        var data2 = {
            "labels": [
                "Vendas",
                "Cobrança",
                "Clientes Novos"
            ],
            "datasets": [
                {
                    "label": "Real",
                    "backgroundColor": "#E28054",
                    "fill": true,
                    "data": [
                        "{{$real_year[0]}}",
                        "{{$real_year[1]}}",
                        "{{$real_year[2]}}"
                    ],
                    "borderColor": "#ffffff",
                    "borderWidth": "1"
                },
                {
                    "label": "Objetivo",
                    "backgroundColor": "#F7B392",
                    "fill": true,
                    "data": [
                        "{{$target_year[0]}}",
                        "{{$target_year[1]}}",
                        "{{$target_year[2]}}"
                    ]
                }
            ]
        };
        var options2 = {
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

        var myChart2 = new Chart(ctx2, {
            type: 'bar',
            data: data2,
            options: options2
        });
    }

</script>

