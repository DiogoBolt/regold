@extends('layouts.app')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/documents/type.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">relatórios pontuais</p>
        <div class="container-bar_img">
            <img src="{{ asset('img/index/icon8.png') }}"/>
        </div>
    </div>

    <div class="container">
        <div class="container-docs">
            <a class="file-link" id="filter-link"  href="/frontoffice/report/punctual" role="button" aria-expanded="false" aria-controls="collapseFilter">
                <strong>Novo Relatório</strong>
            </a>
            @if(count($punctual_datas) > 0)
                <table class="table">
                    <caption>Relatórios</caption>
                    <tr>
                        <th>Cliente</th>
                        <th>Data/Hora</th>
                        <th></th>
                    </tr>

                    @foreach($punctual_datas as $punctual_data)
                        <tr>
                            <td>
                                {{$punctual_data->name}}
                            </td>
                            <td>{{$punctual_data->updated_at}}</td>
                            <td><a href="/frontoffice/report/punctualData/{{$punctual_data->id}}">Ver</a></td>
                        </tr>
                    @endforeach
                </table>
            @else
                <h1>Sem Relatórios Realizados.</h1>
            @endif
        </div>
    </div>

@endsection
