@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/index/client-index.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container index-box">

    <div class="box">
        <a title="Produtos" href="/frontoffice/categories"><img class="img-responsive" src="{{ URL::to('/') }}/img/index/icon6.png"></a>
        <div class="desc">PRODUTOS</div>
        <span class="notification">69</span>
    </div>

    <div class="box">
        <a title="Documentos HACCP" href="/frontoffice/documents/HACCP"><img class="img-responsive" src="{{ URL::to('/') }}/img/index/icon2.png"></a>
        <div class="desc">DOCUMENTOS HACCP</div>
        @if($receiptsHACCP) <span class="notification">{{$receiptsHACCP}}</span> @endif
    </div>

    <div class="box">
        <a title="Controlo de Pragas" href="/frontoffice/documents/Controlopragas"><img class="img-responsive" src="{{ URL::to('/') }}/img/index/icon3.png"></a>
        <div class="desc">CONTROLO DE PRAGAS</div>
        @if($receiptsCP) <span class="notification">{{$receiptsCP}}</span> @endif
    </div>

    <div class="box">
        <a title="Documentos Contabilisticos" href="/frontoffice/documents/Contabilistico"><img class="img-responsive" src="{{ URL::to('/') }}/img/index/icon7.png"></a>
        <div class="desc">DOCUMENTOS CONTABILISTICOS</div>
        @if($receiptsCont) <span class="notification">{{$receiptsCont}}</span> @endif
    </div>

    <div class="box">
        <a title="Encomendas" href="/frontoffice/orders">
            <img class="img-responsive" src="{{ URL::to('/') }}/img/index/icon1.png">
        </a>
        <div class="desc">ENCOMENDAS</div>
        <span class="notification">69</span>
    </div>
</div>
@endsection
