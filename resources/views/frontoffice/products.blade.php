@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/products/products.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">produtos</p>
        <div class="container-bar_img">
            <img src="{{ asset('img/encomendas.jpg') }}" />
        </div>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
            <li class="breadcrumb-item" aria-current="page"><a href="/frontoffice/categories"><strong>Categorias</strong></a></li>
            <li class="breadcrumb-item active" aria-current="page">Produtos</li>
        </ol>
    </nav>

    {{-- Go Back Button --}}
    <a class="back-btn" href="/frontoffice/categories">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Categorias</strong></span>
    </a>

    <div class="container">
        <div class="products-container">
            @foreach($products as $product)
                <div class="product">
                    <div class="product-img" style="background-image: url('/uploads/products/{{$product->file}}')">
                        <a href="/frontoffice/product/{{$product->id}}"></a>
                        <span class="product-img__price">
                            {{$product->price1}}
                        </span>
                    </div>
                    <div class="product-desc">
                        <h2 class="product-desc__title">{{$product->name}}</h2>
                        <div class="product-desc__txt">
                            {{$product->details}}
                        </div>
                        <div class="product-desc__add">
                            <a class="btn btn-add" href="/frontoffice/product/{{$product->id}}">ADICIONAR</a>
                        </div>
                    </div>
                </div>
            @endforeach
            
        </div>
    </div>
@endsection