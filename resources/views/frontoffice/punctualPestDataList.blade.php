@extends('layouts.app')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/documents/type.css') }}" rel="stylesheet">
    <link href="{{ asset('css/orders/orders-bo.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">relatórios pontuais</p>
        <div class="container-bar_img">
            <img src="{{ asset('img/index/icon8.png') }}"/>
        </div>
    </div>

    <a class="file-link" id="filter-link"  href="/frontoffice/report/punctual" role="button" aria-expanded="false" aria-controls="collapseFilter">
        <strong>Novo Relatório</strong>
    </a>


    <div class="container">
        <div class="container-docs">
            @if(count($punctual_datas) > 0)
                @foreach($punctual_datas as $punctual_data)
                    <div class="file">
                        <div class="file-head">
                            Relatório {{$punctual_data->created_at->toDateString()}}
                        </div>
                        <div class="file-body" href="/frontoffice/report/punctualData/{{$punctual_data->id}}">
                            <a href="/frontoffice/report/punctualData/{{$punctual_data->id}}">
                                <img class="file-body__img" src="{{asset('uploads\reports\Report.png')}}">
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <h2>Sem Relatórios Realizados.</h2>
            @endif
        </div>
    </div>

@endsection
