@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/index/client-index.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container index-box">

    <div class="box">
        <a title="Produtos" href="/frontoffice/produtos"><img class="img-responsive" src="{{ URL::to('/') }}/img/index/icon6.png"></a>
        <div class="desc">PRODUTOS</div>
        <span class="notification">69</span>
    </div>

    <div class="box">
        <a title="Documentos HACCP" href="/frontoffice/documents/HACCP"><img class="img-responsive" src="{{ URL::to('/') }}/img/index/icon2.png"></a>
        <div class="desc">DOCUMENTOS HACCP</div>
        <span class="notification">{{$receiptsHACCP}}</span>
    </div>

    <div class="box">
        <a title="Controlo de Pragas" href="/frontoffice/documents/Controlopragas"><img class="img-responsive" src="{{ URL::to('/') }}/img/index/icon3.png"></a>
        <div class="desc">CONTROLO DE PRAGAS</div>
        <span class="notification">{{$receiptsCP}}</span>
    </div>

    <div class="box">
        <a title="Documentos Contabilisticos" href="/frontoffice/documents/Contabilistico"><img class="img-responsive" src="{{ URL::to('/') }}/img/relatorios.jpg"></a>
        <div class="desc">DOCUMENTOS CONTABILISTICOS</div>
        <span class="notification">{{$receiptsCont}}</span>
    </div>

    <div class="box">
        <a title="Encomendas" href="/frontoffice/orders">
            <img class="img-responsive" src="{{ URL::to('/') }}/img/index/icon1.png">
        </a>
        <div class="desc">ENCOMENDAS</div>
        <span class="notification">69</span>
    </div>

    {{-- <i class="box" aria-hidden="true"></i> --}}
</div>
@endsection
