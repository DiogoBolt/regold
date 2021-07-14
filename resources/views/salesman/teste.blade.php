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

<script> function MoreChartOptions(){}
    var ChartData = {
        labels : ["January","February","March","April","May","June","July",],
        datasets : [
            {
                data : [65,8,90,81,56,55,40,],
                backgroundColor :'#3498db',
                borderColor : 'rgba(136,136,136,0.5)',
                label:"2013"},

            {
                data : [21,48,40,19,96,27,100,],
                backgroundColor :'#2ecc71',
                borderColor : '#aaaaaa',
                label:"2014"},

        ]
    };
    ChartOptions= {
        responsive:false,
        layout:{padding:{top:12,left:12,bottom:12,},},
        scales: {
            xAxes:[{
                gridLines:{borderDash:[],},
            }],

            yAxes:[{
                gridLines:{borderDash:[],},
            }],
        },plugins:{
            datalabels:{display:true,
                color:'#241d1d',
                anchor:'end',
                rotation:6,
                offset:10,
                font:{
                    size:20,
                    style:' bold',},},
        },
        legend:{display:false},
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
                borderWidth:3,
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