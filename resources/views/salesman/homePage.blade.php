@extends('layouts.app')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/salesman/homepage.css') }}" rel="stylesheet">
    <script src="https://cdn.anychart.com/releases/8.0.0/js/anychart-base.min.js"></script>
@endsection

@section('content')
<div class="container-bar">
    <p class="container-bar_txt">Home</p>
    <div class="container-bar_img">
        <img src="{{ asset('img/encomendas.jpg') }}" />
    </div>
</div>

            <div class="panel-body table-responsive">

                <div id="chart1" class="divChart1"></div>
                <div id="chart2" class="divChart1"></div>
                <div id="chart3" class="divChart1"></div>
                <table class="customTable">
                    <thead>
                    <tr>
                        <th colspan="2">ENCOMENDAS</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>CLIENTES SP</td>
                        <td><a style="color: red">{{$clients_spOrder}}</a> / <a>{{$clients_sp}}</a></td>
                    </tr>
                    <tr>
                        <td>CLIENTES SP Free</td>
                        <td><a style="color: red">{{$clients_spfreeOrder}}</a> / <a>{{$clients_spfree}}</a></td>
                    </tr>
                    <tr>
                        <td>CLIENTES S</td>
                        <td><a style="color: red">{{$clients_sOrder}}</a> / <a>{{$clients_s}}</a></td>
                    </tr>
                    <tr>
                        <td>CLIENTES ST</td>
                        <td><a style="color: red">{{$clients_stOrder}}</a> / <a>{{$clients_st}}</a></td>
                    </tr>
                    <tr>
                        <td>CLIENTES T</td>
                        <td><a style="color: red">{{$clients_tOrder}}</a> / <a>{{$clients_t}}</a></td>
                    </tr>
                    <tr>
                        <td>TOTAL</td>
                        <td><a style="color: red">{{$clientsOrder}}</a> / <a>{{$clients}}</a></td>
                    </tr>
                    </tbody>
                </table>

                <table class="customTableAg">
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

                <table class="customTable">
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



<script>


    anychart.onDocumentReady(function() {
        // set the data
        var data = {
            /*header: ["Name", "Death toll"],*/
            options: {

            },
            chart: {
                type: 'bar',
                height: 10000,
                stacked: true,
                stackType: '100%'
            },
            credits: {
                enabled: false
            },
            rows: [
                ["Real", 15000],
                ["Objetivo", 87000],
            ]};

        // create the chart
        var chart = anychart.column();

        // add data
        chart.data(data);

        // draw
        chart.container("chart1");
        chart.draw();
    });

    anychart.onDocumentReady(function() {
        // set the data
        var data = {
            /*header: ["Name", "Death toll"],*/
            credits: {
                enabled: false
            },
            rows: [
                ["Real", 15000],
                ["Objetivo", 87000],
            ]};

        // create the chart
        var chart = anychart.column();

        // add data
        chart.data(data);

        // draw
        chart.container("chart2");
        chart.draw();
    });

    anychart.onDocumentReady(function() {
        // set the data
        var data = {
            /*header: ["Name", "Death toll"],*/
            credits: {
                enabled: false
            },
            rows: [
                ["Real", 15000],
                ["Objetivo", 87000],
            ]};

        // create the chart
        var chart = anychart.column();

        // add data
        chart.data(data);

        // draw
        chart.container("chart3");
        chart.draw();
    });

</script>

@endsection















