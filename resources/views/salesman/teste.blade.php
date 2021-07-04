@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/salesman/salesman.css') }}" rel="stylesheet">
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.0/chart.min.js" integrity="sha512-JxJpoAvmomz0MbIgw9mx+zZJLEvC6hIgQ6NcpFhVmbK1Uh5WynnRTTSGv3BTZMNBpPbocmdSJfldgV5lVnPtIw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
@section('content')

    <div class="container">
        <div class="divChart1">
            <canvas id="myChart"></canvas>
        </div>
    </div>


@endsection

<script>
    window.onload = function () {
        let myChart = document.getElementById('myChart').getContext('2d');

        var A=4;
        var B=5;

        let massPopChart = new Chart(myChart,{
            type:'bar',
            data:{
                labels:['A','B'],
                datasets:[{
                    label:'Population',
                    data:[
                        A,
                        B
                    ],
                    backgroundColor:[
                        'rgba(1,64,19,0.95)',
                        'rgba(120,191,106,0.95)'
                    ],
                    barPercentage: 0.2,
                }]
            },
            options:{
                title:{
                    display:true,
                    text:'ola',
                    fontSize:25
                },
                legend:{
                    display: false,
                    position:'right',
                    labels:{
                        fontColor:'#000'
                    }
                },
                layouts:{
                    padding:{
                        left:50,
                        right:0,
                        bottom:0,
                        top:0
                    }
                },
            },
        });
    }



</script>
