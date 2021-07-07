@extends('layouts.app')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/salesman/homepage.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js%22%3E"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0-rc.1/chartjs-plugin-datalabels.min.js" integrity="sha512-+UYTD5L/bU1sgAfWA0ELK5RlQ811q8wZIocqI7+K0Lhh8yVdIoAMEs96wJAIbgFvzynPm36ZCXtkydxu1cs27w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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

                {{--<div class="divChart1">
                    <canvas id="myChart"></canvas>
                </div>--}}

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





    <script>
    window.onload = function (){
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Red', 'Blue'],
                datasets: [{
                    label: '# of Votes',

                    data: [12, 19],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',

                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',

                    ],
                    borderWidth: 1,
                    barPercentage: 0.2,
                }]
            },
            plugins: [ChartDataLabels],
            options: {
                plugins: {
                    legend: {
                        display: false
                    },

                },

                scales: {
                    y: {
                        beginAtZero: true
                    }

                }
            }
        });
    }

</script>

@endsection















