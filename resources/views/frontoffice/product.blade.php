@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/products/product.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">produto</p>
        <div class="container-bar_img">
            <img src="{{ asset('img/encomendas.jpg') }}" />
        </div>
    </div>

    {{-- Go Back Button --}}
    <a class="back-btn" href="/frontoffice/categories">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Categorias</strong></span>
    </a>

    <div class="container">
       
        <div class="product">
            <div class="product__img" style="background-image: url('/uploads/{{$product->id}}/{{$product->file}}')"></div>
            <div class="product__body">
                <div class="product__body-info">
                    <div class="product__body-info-txt">
                        <p> Ref. {{ $product->ref }}</p>
                        <h3> {{ $product->name }} </h3>
                    </div>
                    <div class="product_body-info-prices">
                        <p> {{ $product->price1 }} €</p>
                        <p> {{ $product->price2 }} €</p>
                        <p> {{ $product->price3 }} €</p>
                    </div>
                </div>
                <div class="product__body-desc"> {{ $product->details }}</div>
                <div class="product__body-downloads">
                    <div>
                        <a href="/uploads/{{$product->id}}/{{$product->manual}}" class="btn" download>
                            MANUAL DO PRODUTO <img src="/img/download.png">
                        </a>
                    </div>
                    <div>
                        <a href="/uploads/{{$product->id}}/{{$product->seguranca}}" class="btn" download>
                            FICHA DE SEGURANÇA <img src="/img/download.png">
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection