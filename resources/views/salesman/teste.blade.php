@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/salesman/salesman.css') }}" rel="stylesheet">
@endsection


<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <div class="container">
        <div class="divChart1">
            <canvas  id="chart-01" width="700" height="400"  style="background-color:rgba(255,252,252,1);border-radius:0px;width:700px;height:400px;padding-left:0px;padding-right:0px;padding-top:0px;padding-bottom:0px"></canvas>
        </div>
    </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0-rc.1/chartjs-plugin-datalabels.min.js" integrity="sha512-+UYTD5L/bU1sgAfWA0ELK5RlQ811q8wZIocqI7+K0Lhh8yVdIoAMEs96wJAIbgFvzynPm36ZCXtkydxu1cs27w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script> window.onload = function MoreChartOptions(){}
    var ChartData = {
        labels : ["January","February","NMarc",],
        datasets : [
            {
                data : [65,8,2,],
                backgroundColor :'#0a630a',
                borderColor : 'rgba(0,0,0,0.5)',
                label:"2013"},

            {
                data : [21,48,3,],
                backgroundColor :'rgba(93,176,37,0.68)',
                borderColor : '#aaaaaa',
                label:"2014"},

        ]
    };
    ChartOptions= {
        responsive:false,
        layout:{padding:{top:12,left:60,bottom:12,},},
        scales: {
            xAxes:[{
                gridLines:{color:'rgba(255,252,252,0)',lineWidth:0,borderDash:[],},
            }],

            yAxes:[{
                gridLines:{color:'rgba(255,252,252,0)',lineWidth:0,borderDash:[],},
            }],
        },plugins:{
            datalabels:{display:true,
                anchor:'end',
                align:'end',
                offset:1,
                font:{
                    style:' bold',},},
        },
        legend:{
            labels:{
                fontColor:'#000000',
                boxWidth:39,
                generateLabels: function(chart){
                    return  chart.data.datasets.map( function( dataset, i ){
                        return{
                            text:dataset.label,
                            lineCap:dataset.borderCapStyle,
                            lineDash:[],
                            lineDashOffset: 0,
                            lineJoin:dataset.borderJoinStyle,
                            fillStyle:dataset.backgroundColor,
                            strokeStyle:dataset.borderColor,
                            lineWidth:dataset.pointBorderWidth,
                            lineDash:dataset.borderDash,
                        }
                    })
                },

            },
        },

        title:{
            display:true,
            text:'Chart Title',
            fontColor:'#3498db',
            fontSize:32,
            fontStyle:' bold',
        },
        elements: {
            arc: {
            },
            line: {
            },
            rectangle: {
                borderWidth:0.01,
            },
        },
        tooltips:{
        },
        hover:{
            mode:'nearest',
            animationDuration:400,
        },
    };
    DrawTheChart(ChartData,ChartOptions,"chart-01","bar");</script>