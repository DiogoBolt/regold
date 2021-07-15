@extends('layouts.app')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/salesman/statistics.css') }}" rel="stylesheet">
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
        <div class="charts_container">

            <div class="chart">
                <canvas id="myChart" ></canvas>
            </div>

            <div class="chart2">
                <canvas id="myChart2" ></canvas>
            </div>

        </div>

        <div class="statisticsTable_container">
            <div>
                <table class="table">
                    <tr>
                        <th style="background-color:#199400;">VALOR ACUMULADO</th>
                        <th style="background-color:#199400;">107.75€</th>
                    </tr>
                    <tr>
                        <td>VALOR OBJETIVO ESTIMADO</td>
                        <td>707.78€</td>
                    </tr>

                </table>
            </div>


                <div>
                    <table class="table">
                        <tr>
                            <th style="background-color:#ea7f4f;">VALOR ACUMULADO</th>
                            <th style="background-color:#ea7f4f;">107.75€</th>
                        </tr>
                        <tr>
                            <td>VALOR OBJETIVO ESTIMADO</td>
                            <td>707.78€</td>
                        </tr>

                    </table>
                </div>


                    <div>
                        <table class="table">
                            <tr>
                                <th style="background-color:#e59c1f;">MELHOR MÊS VENDAS</th>
                                <th style="background-color:#e59c1f;">AGOSTO</th>
                            </tr>
                            <tr>
                                <td>MELHOR MÊS COBRANÇA</td>
                                <td>SETEMBRO</td>
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
                    "backgroundColor": "#f36122",
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
                    "backgroundColor": "#ff9483",
                    "fill": true,
                    "data": [
                        "200",
                        "300",
                        "280"
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

